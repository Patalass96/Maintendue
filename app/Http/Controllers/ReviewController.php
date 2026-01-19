<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Donation;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Afficher les avis d'un utilisateur
     */
    public function index(User $user = null)
    {
        $user = $user ?? Auth::user();

        $reviews = Review::where('reviewed_id', $user->id)
            ->where('is_visible', true)
            ->with(['reviewer', 'donation'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Statistiques
        $stats = [
            'total' => $reviews->total(),
            'average' => Review::where('reviewed_id', $user->id)->avg('rating') ?? 0,
            'count_by_rating' => Review::where('reviewed_id', $user->id)
                ->selectRaw('rating, COUNT(*) as count')
                ->groupBy('rating')
                ->pluck('count', 'rating')
                ->toArray(),
        ];

        return view('reviews.index', compact('user', 'reviews', 'stats'));
    }

    /**
     * Créer un nouvel avis
     */
    public function create(Donation $donation)
    {
        // Vérifier que l'utilisateur peut laisser un avis
        $this->authorize('createReview', [$donation]);

        return view('reviews.create', compact('donation'));
    }

    /**
     * Afficher un avis particulier
     */
    public function show(Review $review)
    {
        $this->authorize('view', $review);

        $review->load(['reviewer', 'reviewed', 'donation']);

        return view('reviews.show', compact('review'));
    }
    /**
     * Stocker un nouvel avis
     */
    public function store(Request $request, Donation $donation)
    {
        $this->authorize('createReview', [$donation]);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        // Déterminer qui est évalué
        $reviewedUser = Auth::user()->isAssociation()
            ? $donation->donor
            : $donation->assignedAssociation;

        $review = Review::create([
            'reviewer_id' => Auth::id(),
            'reviewed_id' => $reviewedUser->id,
            'donation_id' => $donation->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_visible' => true,
        ]);

        // Mettre à jour la note moyenne de l'utilisateur
        $this->updateUserRating($reviewedUser);

        // Notifier l'utilisateur évalué
        app(NotificationService::class)->notifyNewReview($review);

        return redirect()->route('reviews.show', $review)
            ->with('success', 'Avis publié avec succès!');
    }

    /**
     * Répondre à un avis
     */
    public function reply(Request $request, Review $review)
    {
        $this->authorize('reply', $review);

        $validated = $request->validate([
            'response' => 'required|string|min:5|max:500',
        ]);

        $review->update(['response' => $validated['response']]);

        return back()->with('success', 'Réponse publiée avec succès!');
    }

    /**
     * Signaler un avis
     */
    public function report(Request $request, Review $review)
    {
        $validated = $request->validate([
            'reason' => 'required|string|in:inappropriate,false_information,spam,other',
            'description' => 'required|string|min:10|max:500',
        ]);

        // Créer le signalement
        $report = $review->reports()->create([
            'reporter_id' => Auth::id(),
            'reason' => $validated['reason'],
            'description' => $validated['description'],
            'status' => 'pending',
        ]);

        // Notifier les administrateurs
        $this->notifyAdminsAboutReport($report);

        return back()->with('success', 'Avis signalé. Merci pour votre vigilance.');
    }

    /**
     * Mettre à jour la note moyenne d'un utilisateur
     */
    private function updateUserRating(User $user)
    {
        $averageRating = Review::where('reviewed_id', $user->id)
            ->avg('rating');

        $user->update(['average_rating' => round($averageRating, 1)]);
    }

    /**
     * Notifier les administrateurs d'un signalement
     */
    private function notifyAdminsAboutReport($report)
    {
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            $admin->notify(
                'report_created',
                'Nouveau signalement d\'avis',
                "Un avis a été signalé pour violation des règles.",
                [
                    'report_id' => $report->id,
                    'review_id' => $report->reported_id,
                    'reason' => $report->reason
                ],
                route('admin.moderation.reports.show', $report)
            );
        }
    }
}
