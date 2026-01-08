<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;


class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Où rediriger les utilisateurs après l'inscription.
     * Modifié : Maintenant on redirige toujours vers login pour forcer la connexion
     */
    protected $redirectTo = '/login';

    /**
     * Validation des données du formulaire.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'role' => [
                'required',
                Rule::in([
                    User::ROLE_DONATOR,
                    User::ROLE_ASSOCIATION,
                ]),
            ],
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            // 'terms'    => ['required', 'accepted'],
        ], [
            // 'terms.required' => 'Vous devez accepter les conditions d\'utilisation.',
            // 'terms.accepted' => 'Vous devez accepter les conditions d\'utilisation.',
        ]);
    }

    /**
     * Création de l'utilisateur avec le rôle choisi.
     */
    protected function create(array $data)
    {
        return User::create([
            'name'       => $data['name'],
            'email'      => $data['email'],
            'password'   => Hash::make($data['password']),
            'role'       => $data['role'],
            'is_verified' => $data['role'] === User::ROLE_ASSOCIATION ? false : true,
            'is_active'  => true,
        ]);
    }

    /**
     * Redirection après inscription réussie.
     * Modifié : On ne connecte plus automatiquement, on redirige vers login
     */
    protected function registered(Request $request, $user)
    {
        // On NE connecte PAS l'utilisateur automatiquement
        // Auth::login($user); // RETIRÉ
        
        // Message de succès différent selon le rôle
        $messages = [
            'association' => 'Inscription réussie ! Vous pouvez maintenant vous connecter pour compléter votre profil association.',
            'donateur' => 'Inscription réussie ! Vous pouvez maintenant vous connecter à votre compte donateur.',
        ];
        
        $roleKey = $user->role === 'association' ? 'association' : 'donateur';
        
        // Redirection vers la page de connexion avec message
        return redirect($this->redirectPath())
            ->with('success', $messages[$roleKey]);
    }

    /**
     * Afficher le formulaire d'inscription avec les rôles disponibles.
     */
    public function showRegistrationForm()
    {
        return view('auth.register', [
            'roles' => [
                'donateur' => 'Donateur',
                'association' => 'Association'
            ]
        ]);
    }

    /**
     * Gérer une demande d'inscription.
     * Surcharge pour personnaliser la réponse
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        // Optionnel : envoyer un email de bienvenue
        // $this->sendWelcomeEmail($user);

        // Optionnel : créer le profil association si nécessaire
        if ($user->role === 'association') {
            // Vous pourriez créer un profil association vide ici
            // Association::create(['user_id' => $user->id]);
        }

        // On appelle registered() qui redirigera vers login
        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    /**
     * Envoyer un email de bienvenue (optionnel)
     */
    protected function sendWelcomeEmail(User $user)
    {
        Mail::to($user->email)->send(new WelcomeEmail($user));
        return response()->json([
            'message' => 'Inscription réussie. Email envoyé.',
            'user' => $user
        ], 201);
    }
}
// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use App\Models\User;
// use Illuminate\Foundation\Auth\RegistersUsers;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Validator;
//  use illuminate\Http\Response;
// use Illuminate\Http\Request;
// use Illuminate\Validation\Rule;
// use Illuminate\Support\Facades\Auth;

// class RegisterController extends Controller
// {
//     use RegistersUsers;

//     /**
//      * Où rediriger les utilisateurs après l'inscription.
//      */
//     protected function $redirectTo = '/login'
//     {
//         if (auth()->user()->role === 'association') {
//             // Redirige vers la page des formalités si l'association n'est pas encore vérifiée
//             return '/association/complete-profile';
//         }

//         return '/donator/dashboard';
//     }

    

//     /**
//      * Validation des données du formulaire (fidèle à tes champs).
//      */
//   protected function validator(array $data)
// {
//     return Validator::make($data, [
//         'role' => [
//             'required',
//             Rule::in([
//                 User::ROLE_DONATOR,
//                 User::ROLE_ASSOCIATION,
//             ]),
//         ],
//         'name'     => ['required', 'string', 'max:255'],
//         'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
//         'password' => ['required', 'string', 'min:8', 'confirmed'],
//     ]);
// }


//     /**
//      * Création de l'utilisateur avec le rôle choisi.
//      */
//    protected function create(array $data)
// {
//     return User::create([
//         'name'       => $data['name'],
//         'email'      => $data['email'],
//         'password'   => Hash::make($data['password']),
//         'role'       => $data['role'],
//         'is_verified'=> $data['role'] === User::ROLE_ASSOCIATION ? false : true,
//     ]);
// }

// }