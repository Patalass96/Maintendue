<footer class="footer">
    <div class="footer-main">
        <div class="container">
            <div class="row">
                <!-- Colonne 1: Logo et description -->
                <div class="col-md-4">
                    <div class="footer-brand">
                        <div class="brand-logo">
                            <img src="{{ asset('assets/images/logos/MainTendue.png') }}" 
                                 alt="MainTendue Logo">
                        </div>
                        <h3>MAIN <span>TENDUE</span></h3>
                        <p class="footer-description">
                            Plateforme de solidarité connectant donateurs, associations et bénéficiaires 
                            pour redistribuer efficacement les dons essentiels au Togo.
                        </p>
                        <div class="social-links">
                            <a href="#" class="social-link" title="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-link" title="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="social-link" title="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-link" title="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="social-link" title="YouTube">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Colonne 2: Liens rapides -->
                <div class="col-md-2">
                    <h4 class="footer-title">Donner</h4>
                    <ul class="footer-links">
                        <li><a href="{{ url('/donations/create') }}">Publier un don</a></li>
                        <li><a href="{{ url('/donations') }}">Dons disponibles</a></li>
                        <li><a href="#">Catégories</a></li>
                        <li><a href="#">Points de collecte</a></li>
                    </ul>
                </div>
                
                <!-- Colonne 3: Pour les associations -->
                <div class="col-md-2">
                    <h4 class="footer-title">Associations</h4>
                    <ul class="footer-links">
                        <li><a href="{{ url('/associations/register') }}">Inscription association</a></li>
                        <li><a href="{{ url('/associations') }}">Nos associations</a></li>
                        <li><a href="#">Devenir partenaire</a></li>
                        <li><a href="#">Guide association</a></li>
                    </ul>
                </div>
                
                <!-- Colonne 4: Informations -->
                <div class="col-md-4">
                    <h4 class="footer-title">Contact & Infos</h4>
                    <div class="footer-contact">
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <strong>Siège social</strong>
                                <p>Rue de la Solidarité, Lomé, Togo</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <div>
                                <strong>Téléphone</strong>
                                <p>+228 92719630/99444263</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <strong>Email</strong>
                                <p>maintenduepatience01@gmail.com</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-content">
                <div class="copyright">
                    <p>&copy; {{ date('Y') }} MAIN TENDUE. Tous droits réservés.</p>
                </div>
                
                <div class="footer-legal">
                    <a href="#">Confidentialité</a>
                    <a href="#">Conditions</a>
                    <a href="#">Mentions légales</a>
                </div>
            </div>
        </div>
    </div>
</footer>