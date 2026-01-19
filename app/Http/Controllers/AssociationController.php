<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Association;
use App\Models\Donation;
use App\Models\DonationRequest;
use App\Models\UserNotificationSetting;
use App\Models\Notification;
use App\Models\User;
use App\Models\Message;
use App\Models\DonationImage;
use App\Models\Category;


class AssociationController extends Controller
{


/**
     * Afficher la liste publique des associations
     */
    public function publicIndex()
    {
        $associations = Association::where('verification_status', 'verified')
            ->with('manager')
            ->latest()
            ->paginate(12);

        return view('associations.index', compact('associations'));
    }

    /**
     * Afficher le dashboard de l'association
     */

    public function index()
    {
        $association = Auth::user()->association;

        if (!$association) {
            return redirect()->route('associations.complete-profile')
                ->with('warning', 'Veuillez compléter votre profil association.');
        }

        // Vérifier le statut de vérification
        if ($association->verification_status !== 'verified') {
            return redirect()->route('associations.pending')
                ->with('warning', 'Votre association est en attente de validation.');
        }

        // Statistiques
        $stats = [
            'total_donations' => $association->acceptedDonations()->count(),
            'pending_donations' => Donation::where('status', 'available')->count(),
            'pending_requests' => $association->requests()->where('status', 'pending')->count(),
            'messages' => 0,
            'rating' => $association->stats_satisfaction_rate ?? 0,
        ];

        return view('associations.dashboard', compact('association', 'stats'));
    }
      /**
     * Afficher la liste publique des associations
     */
    public function indexPublic()
    {
        $associations = Association::where('verification_status', 'verified')
            ->with('manager')
            ->paginate(15);

        return view('associations.index', compact('associations'));
    }

    /**
     * Afficher le profil public d'une association
     */
    public function show(Association $association)
    {
        // Vérifier que l'association est vérifiée et active
        if ($association->verification_status !== 'verified' || !$association->manager->is_active) {
            abort(404, 'Association non trouvée');
        }

        // Charger les relations
        $association->load([
            'manager',
            'collectionPoints',
            'requests' => function ($query) {
                $query->where('status', 'active')->limit(6);
            }
        ]);

        // Statistiques
        $stats = [
            'total_donations' => $association->stats_total_donations ?? 0,
            'satisfaction_rate' => $association->stats_satisfaction_rate ?? 0,
            'active_requests' => $association->requests()->where('status', 'active')->count(),
            'collection_points' => $association->collectionPoints()->count(),
        ];

        return view('associations.show', compact('association', 'stats'));
    }

    /**
     * Afficher le formulaire de complétion de profil
     */
    public function showCompleteProfile()
    {
        $user = Auth::user();
        $association = $user->association;

        // Si déjà créée et vérifiée, rediriger vers le dashboard
        if ($association && $association->verification_status === 'verified') {
            return redirect()->route('associations.dashboard');
        }

        return view('associations.complete-profile', [
            'user' => $user,
            'association' => $association
        ]);
    }

    /**
     * Afficher l'état de validation en attente
     */
    public function pending()
    {
        $user = Auth::user();
        $association = $user->association;

        // Si pas d'association, rediriger vers la création
        if (!$association) {
            return redirect()->route('associations.complete-profile')
                ->with('warning', 'Veuillez d\'abord créer votre profil association.');
        }

        // Si vérifiée, rediriger vers le dashboard
        if ($association->verification_status === 'verified') {
            return redirect()->route('associations.dashboard');
        }

        $status = match($association->verification_status) {
            'pending' => 'Votre association est en attente de validation par nos administrateurs.',
            'rejected' => 'Votre association a été rejetée. Veuillez contacter le support pour plus d\'informations.',
            default => 'État de validation inconnu.',
        };

        return view('associations.pending', [
            'user' => $user,
            'association' => $association,
            'status' => $status,
            'verification_status' => $association->verification_status,
        ]);
    }

    /**
     * Traiter le formulaire de complétion de profil (TOUS MODÈLES)
     */
    // public function completeProfile(Request $request)
    // {
    //     $user = Auth::user();

    //     // Validation complète pour tous les modèles
    //     $validated = $request->validate([
    //         // Champs Association (obligatoires)
    //         'legal_name' => 'required|string|max:255',
    //         'description' => 'required|string',
    //         'contact_person' => 'required|string|max:255',
    //         'phone' => 'required|string|max:20',
    //         'legal_address' => 'required|string',

    //         // Champs Association (optionnels)
    //         'registration_number' => 'nullable|string|unique:associations,registration_number',
    //         'website' => 'nullable|url',
    //         'needs_description' => 'nullable|string',
    //         'opening_hours' => 'nullable|string',
    //         'delivery_radius' => 'nullable|integer|min:0|max:200',
    //         'accepts_direct_delivery' => 'boolean',
    //         'accepts_collection_points' => 'boolean',
    //         'logo' => 'nullable|image|max:2048', // 2MB
    //         'verification_document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB

    //         // Champs Donation (optionnels)
    //         'item_type' => 'nullable|string|in:clothing,shoes,food,school,furniture,other',
    //         'school_level' => 'nullable|string|max:100',
    //         'quantity' => 'nullable|integer|min:1|max:1000',
    //         'condition' => 'nullable|string|in:new,very_good,good,used',

    //         // Champs DonationRequest (optionnels)
    //         'request_title' => 'nullable|string|max:255',
    //         'request_message' => 'nullable|string',

    //         // Notifications (UserNotificationSetting)
    //         'notification_settings.email_new_donations' => 'boolean',
    //         'notification_settings.email_messages' => 'boolean',
    //         'notification_settings.email_requests' => 'boolean',
    //         'notification_settings.push_new_donations' => 'boolean',
    //         'notification_settings.push_messages' => 'boolean',

    //         // Messagerie (Message/Conversation preferences)
    //         'messaging_preferences.default_message_template' => 'nullable|string',
    //         'messaging_preferences.auto_reply_enabled' => 'boolean',
    //         'messaging_preferences.notify_on_message' => 'boolean',

    //         // Reviews/Reports preferences
    //         'review_preferences.auto_request_review' => 'nullable|in:1,7,14',
    //         'review_preferences.show_ratings_public' => 'boolean',
    //         'review_preferences.auto_report_issues' => 'boolean',
    //     ]);

    //     // ==== 1. CRÉER/METTRE À JOUR L'ASSOCIATION ====
    //     $association = $user->association ?? new Association();

    //     $association->user_id = $user->id;
    //     $association->fill($request->only([
    //         'legal_name',
    //         'description',
    //         'registration_number',
    //         'legal_address',
    //         'contact_person',
    //         'phone',
    //         'website',
    //         'needs_description',
    //         'opening_hours',
    //         'delivery_radius'
    //     ]));

    //     // Gérer les booléens (car ils ne sont pas inclus dans fill() si non cochés)
    //     $association->accepts_direct_delivery = $request->boolean('accepts_direct_delivery');
    //     $association->accepts_collection_points = $request->boolean('accepts_collection_points');

    //     $association->verification_status = 'pending';

    //     // Gérer l'upload du logo
    //     if ($request->hasFile('logo')) {
    //         $logoPath = $request->file('logo')->store('associations/logos', 'public');
    //         $association->logo = $logoPath;
    //     }

    //     // Gérer l'upload du document de vérification
    //     if ($request->hasFile('verification_document')) {
    //         $docPath = $request->file('verification_document')->store('associations/documents', 'public');
    //         $association->verification_document = $docPath;
    //     }

    //     $association->save();

    //     // ==== 2. CRÉER LES PRÉFÉRENCES DE NOTIFICATION ====
    //     $notificationSettings = $user->notificationSettings ?? new UserNotificationSetting();
    //     $notificationSettings->user_id = $user->id;
    //     $notificationSettings->fill($request->input('notification_settings', [
    //         'email_new_donations' => true,
    //         'email_messages' => true,
    //         'email_requests' => true,
    //         'push_new_donations' => true,
    //         'push_messages' => true,
    //     ]));
    //     $notificationSettings->save();

    //     // ==== 3. CRÉER UNE DEMANDE DE DON SI RENSEIGNÉE ====
    //     if ($request->filled('request_title') || $request->filled('request_message')) {
    //         $donationRequest = new DonationRequest();
    //         $donationRequest->association_id = $association->id;
    //         // $donationRequest->title = $request->input('request_title', 'Demande de dons');
    //         $donationRequest->message = $request->input('request_message');
    //         $donationRequest->status = 'pending';
    //         $donationRequest->save();

    //         // Notification pour l'admin
    //         $this->createAdminNotification(
    //             'Nouvelle demande d\'association',
    //             "L'association {$association->legal_name} a créé une nouvelle demande de dons.",
    //             'admin/donation-requests'
    //         );
    //     }

    //     // ==== 4. CRÉER UN BESOIN (DONATION) SI RENSEIGNÉ ====
    //     if ($request->filled('item_type') || $request->filled('needs_description')) {
    //         $need = new \App\Models\AssociationNeed();
    //         $need->association_id = $association->id;
    //         $need->title = $request->filled('request_title')
    //             ? $request->input('request_title')
    //             : 'Besoins de ' . $association->legal_name;
    //         $need->description = $request->input('needs_description', '');
    //         $need->item_type = $request->input('item_type');
    //         $need->school_level = $request->input('school_level');
    //         $need->quantity = $request->input('quantity', 1);
    //         $need->condition = $request->input('condition');
    //         $need->status = 'active';
    //         $need->save();
    //     }

    //     // ==== 5. NOTIFICATIONS ====
    //     // Notification de bienvenue pour l'utilisateur
    //     $this->createUserNotification(
    //         $user->id,
    //         'Bienvenue sur Main Tendue !',
    //         'Votre profil association a été soumis avec succès. Notre équipe le validera sous 24-48h.',
    //         'info',
    //         route('associations.complete-profile')
    //     );

    //     // Notification pour les administrateurs
    //     $this->createAdminNotification(
    //         'Nouvelle association à valider',
    //         "L'association {$association->legal_name} a soumis son profil pour validation.",
    //         'admin/associations'
    //     );

    //     return redirect()->route('associations.complete-profile')
    //         ->with('success', 'Profil soumis avec succès ! En attente de validation.');
    // }

    public function completeProfile(Request $request)
{
    $user = Auth::user();

    // Validation simplifiée
    $validated = $request->validate([
        // Champs obligatoires
        'legal_name' => 'required|string|max:255',
        'description' => 'required|string',
        'contact_person' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'legal_address' => 'required|string',
        'verification_document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',

        // Champs optionnels
        'registration_number' => 'nullable|string|unique:associations,registration_number',
        'website' => 'nullable|url',
        'needs_description' => 'nullable|string',
        'opening_hours' => 'nullable|string',
        'delivery_radius' => 'nullable|integer|min:0|max:200',
        'accepts_direct_delivery' => 'boolean',
        'accepts_collection_points' => 'boolean',
        'logo' => 'nullable|image|max:2048',

        // Champs pour AssociationNeed (optionnels)
        'item_type' => 'nullable|string|in:clothing,shoes,food,school,furniture,other',
        'school_level' => 'nullable|string|max:100',
        'quantity' => 'nullable|integer|min:1|max:1000',
        'condition' => 'nullable|string|in:new,very_good,good,used',
        'request_title' => 'nullable|string|max:255',
        'request_message' => 'nullable|string',
    ]);

    // ==== 1. CRÉER/METTRE À JOUR L'ASSOCIATION ====
    $association = $user->association ?? new Association();

    $association->user_id = $user->id;
    $association->fill($request->only([
        'legal_name', 'description', 'registration_number',
        'legal_address', 'contact_person', 'phone', 'website',
        'needs_description', 'opening_hours', 'delivery_radius'
    ]));

    $association->accepts_direct_delivery = $request->boolean('accepts_direct_delivery');
    $association->accepts_collection_points = $request->boolean('accepts_collection_points');
    $association->verification_status = 'pending';

    // Upload du logo
    if ($request->hasFile('logo')) {
        $logoPath = $request->file('logo')->store('associations/logos', 'public');
        $association->logo = $logoPath;
    }

    // Upload du document
    if ($request->hasFile('verification_document')) {
        $docPath = $request->file('verification_document')->store('associations/documents', 'public');
        $association->verification_document = $docPath;
    }

    $association->save();

    // ==== 2. CRÉER UN AssociationNeed SI BESOIN (PAS DE DonationRequest) ====
    // NE PAS créer de DonationRequest ici - elle nécessite un donation_id
    if ($request->filled('item_type') || $request->filled('needs_description') || $request->filled('request_title')) {
        try {
            // Vérifiez si le modèle AssociationNeed existe
            $needModel = 'App\Models\AssociationNeed';

            if (class_exists($needModel)) {
                $need = new $needModel();
                $need->association_id = $association->id;

                // Titre
                $need->title = $request->filled('request_title')
                    ? $request->input('request_title')
                    : 'Besoins de ' . $association->legal_name;

                // Description combinée
                $description = '';
                if ($request->filled('needs_description')) {
                    $description .= $request->input('needs_description');
                }
                if ($request->filled('request_message')) {
                    if (!empty($description)) $description .= "\n\n";
                    $description .= $request->input('request_message');
                }
                $need->description = $description ?: 'Description des besoins';

                $need->item_type = $request->input('item_type', 'other');
                $need->school_level = $request->input('school_level');
                $need->quantity = $request->input('quantity', 1);
                $need->condition = $request->input('condition');
                $need->status = 'active';
                $need->urgency = 'medium';
                $need->save();
            }
        } catch (\Exception $e) {
            // Log l'erreur mais continuez
            \Log::error('Erreur création AssociationNeed: ' . $e->getMessage());
        }
    }

    return redirect()->route('associations.complete-profile')
        ->with('success', 'Profil soumis avec succès ! En attente de validation.');
}

    /**
     * Afficher les dons disponibles
     */
    public function availableDonations()
    {
        $association = Auth::user()->association;

        $donations = Donation::where('status', 'available')
            ->with('category', 'primaryImage')
            ->latest()
            ->paginate(12);

        return view('/associations.donations.available', compact('donations', 'association'));
    }

    /**
     * Afficher les dons reçus
     */
    public function receivedDonations()
    {
        $association = Auth::user()->association;

        $donations = $association->acceptedDonations()
            ->with('category', 'donor', 'primaryImage')
            ->latest()
            ->paginate(10);

        // Statistiques
        $monthCount = $association->acceptedDonations()
            ->whereMonth('created_at', now()->month)
            ->count();

        $pendingCount = $association->acceptedDonations()
            ->where('status', 'accepted')
            ->count();

        $deliveredCount = $association->acceptedDonations()
            ->where('status', 'delivered')
            ->count();

        return view('associations.donations.received', compact(
            'donations',
            'association',
            'monthCount',
            'pendingCount',
            'deliveredCount'
        ));
    }

    /**
     * Afficher le profil public
     */
    public function showProfile()
    {
        $association = Auth::user()->association;
        return view('associations.profile.show', compact('association'));
    }

    /**
     * Afficher le formulaire d'édition du profil
     */
    public function editProfile()
    {
        $association = Auth::user()->association;
        return view('associations.profile.edit', compact('association'));
    }

    /**
     * Mettre à jour le profil
     */
    public function updateProfile(Request $request)
    {
        $association = Auth::user()->association;

        $validated = $request->validate([
            'description' => 'required|string',
            'needs_description' => 'nullable|string',
            'phone' => 'required|string|max:20',
            'website' => 'nullable|url',
            'opening_hours' => 'nullable|string',
            'delivery_radius' => 'nullable|integer|min:0|max:200',
            'accepts_direct_delivery' => 'boolean',
            'accepts_collection_points' => 'boolean',
            'logo' => 'nullable|image|max:2048',
        ]);

        $association->update($validated);

        // Gérer l'upload du logo
        if ($request->hasFile('logo')) {
            // Supprimer l'ancien logo s'il existe
            if ($association->logo && Storage::disk('public')->exists($association->logo)) {
                Storage::disk('public')->delete($association->logo);
            }

            $logoPath = $request->file('logo')->store('associations/logos', 'public');
            $association->logo = $logoPath;
            $association->save();
        }

        return redirect()->route('association.profile')
            ->with('success', 'Profil mis à jour avec succès.');
    }

    /**
     * Afficher les messages
     */
    public function messages()
    {
        return view('association.messages');
    }

    /**
     * Accepter un don
     */
    public function acceptDonation(Request $request, $donationId)
    {
        $donation = Donation::findOrFail($donationId);
        $association = Auth::user()->association;

        // Vérifier que le don est disponible
        if ($donation->status !== 'available') {
            return back()->with('error', 'Ce don n\'est plus disponible.');
        }

        // Assigner le don à l'association
        $donation->assigned_association_id = $association->id;
        $donation->status = 'accepted';
        $donation->save();

        // Mettre à jour les statistiques
        $association->increment('stats_total_donations');

        // Créer une notification pour le donateur
        $this->createUserNotification(
            $donation->donor_id,
            'Votre don a été accepté !',
            "L'association {$association->legal_name} a accepté votre don.",
            'success',
            route('donations.show', $donation)
        );

        return back()->with('success', 'Don accepté avec succès !');
    }

    /**
     * Marquer un don comme livré
     */
    public function markAsDelivered($donationId)
    {
        $donation = Donation::findOrFail($donationId);
        $association = Auth::user()->association;

        // Vérifier que l'association est bien celle qui a accepté le don
        if ($donation->assigned_association_id !== $association->id) {
            return back()->with('error', 'Vous n\'êtes pas autorisé à modifier ce don.');
        }

        $donation->status = 'delivered';
        $donation->delivered_at = now();
        $donation->save();

        // Créer une notification pour le donateur
        $this->createUserNotification(
            $donation->donor_id,
            'Votre don a été livré !',
            "L'association {$association->legal_name} a confirmé la livraison de votre don.",
            'success',
            route('donations.show', $donation)
        );

        return back()->with('success', 'Don marqué comme livré !');
    }

    /**
     * Afficher les demandes de l'association
     */
    public function myRequests()
    {
        $association = Auth::user()->association;
        $requests = $association->requests()
            ->with('donation')
            ->latest()
            ->paginate(10);

        return view('association.requests.index', compact('requests', 'association'));
    }

    /**
     * Formulaire pour créer une demande
     */
    public function createRequestForm()
    {
        $association = Auth::user()->association;
        return view('association.requests.create', compact('association'));
    }

    /**
     * Créer une demande de don spécifique
     */
    public function createDonationRequest(Request $request)
    {
        $association = Auth::user()->association;

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'item_type' => 'nullable|string|in:clothing,shoes,food,school,furniture,other',
            'quantity' => 'nullable|integer|min:1',
            'urgency' => 'nullable|string|in:low,medium,high,urgent',
            'proposed_date' => 'nullable|date',
        ]);

        $donationRequest = new DonationRequest();
        $donationRequest->association_id = $association->id;
        $donationRequest->fill($validated);
        $donationRequest->status = 'pending';
        $donationRequest->save();

        // Notification pour l'admin
        $this->createAdminNotification(
            'Nouvelle demande d\'association',
            "L'association {$association->legal_name} a créé une nouvelle demande : {$request->title}",
            'admin/donation-requests'
        );

        return redirect()->route('association.requests')
            ->with('success', 'Demande créée avec succès !');
    }

    /**
     * Afficher une demande spécifique
     */
    public function showRequest($id)
    {
        $association = Auth::user()->association;
        $request = DonationRequest::where('association_id', $association->id)
            ->findOrFail($id);

        return view('association.requests.show', compact('request', 'association'));
    }

    /**
     * Supprimer le logo
     */
    public function deleteLogo()
    {
        $association = Auth::user()->association;

        if ($association->logo && Storage::disk('public')->exists($association->logo)) {
            Storage::disk('public')->delete($association->logo);
            $association->logo = null;
            $association->save();
        }

        return back()->with('success', 'Logo supprimé avec succès.');
    }

    /**
     * Télécharger le document de vérification
     */
    public function downloadVerificationDocument()
    {
        $association = Auth::user()->association;

        if (!$association->verification_document) {
            return back()->with('error', 'Aucun document disponible.');
        }

        return Storage::disk('public')->download($association->verification_document);
    }

    /**
     * ============ MÉTHODES PRIVÉES UTILITAIRES ============
     */

    /**
     * Créer une notification pour l'utilisateur
     */
    private function createUserNotification($userId, $title, $message, $type = 'info', $actionUrl = null)
    {
        $notification = new Notification();
        $notification->user_id = $userId;
        $notification->type = $type;
        $notification->title = $title;
        $notification->message = $message;
        $notification->data = [
            'association_id' => Auth::user()->association->id ?? null,
            'created_at' => now()->toDateTimeString(),
        ];
        $notification->action_url = $actionUrl;
        $notification->save();

        return $notification;
    }

    /**
     * Créer une notification pour tous les administrateurs
     */
    private function createAdminNotification($title, $message, $actionUrl)
    {
        $admins = User::where('role', 'admin')
            ->where('is_active', true)
            ->get();

        foreach ($admins as $admin) {
            $notification = new Notification();
            $notification->user_id = $admin->id;
            $notification->type = 'warning';
            $notification->title = $title;
            $notification->message = $message;
            $notification->data = [
                'association_id' => Auth::user()->association->id ?? null,
                'urgency' => 'medium',
                'created_at' => now()->toDateTimeString(),
            ];
            $notification->action_url = $actionUrl;
            $notification->save();
        }

        return true;
    }
}
