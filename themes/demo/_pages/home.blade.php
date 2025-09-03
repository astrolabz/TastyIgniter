---
title: Modern Restaurant
layout: default
permalink: /
---

<!-- Hero Section -->
<section class="hero bg-dark text-white py-5" data-aos="fade-in">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4" style="font-family: 'Playfair Display', serif;">Benvenuti al Nostro Ristorante</h1>
                <p class="lead mb-4">Scopri i nostri piatti freschi e deliziosi. Ordina online per un'esperienza culinaria eccezionale.</p>
                <a href="{{ url('/checkout') }}" class="btn btn-light btn-lg">Ordina Ora</a>
            </div>
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1498654896293-37aacf113fd9?auto=format&fit=crop&w=1400&q=80" alt="Sala del ristorante" class="img-fluid rounded">
            </div>
        </div>
    </div>
</section>

<!-- Menu Carousel (Ispirato ReactBits) -->
<section id="menu" class="menu-carousel py-5 bg-light" data-aos="fade-up">
    <div class="container">
        <h2 class="text-center mb-5" style="font-family: 'Playfair Display', serif;">Il Nostro Menu</h2>
        <div id="menuCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="row">
                        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
                            <div class="card h-100 shadow-sm">
                                <img src="https://images.unsplash.com/photo-1521389508051-d7ffb5dc8bbf?auto=format&fit=crop&w=1200&q=80" class="card-img-top" alt="Pasta fresca">
                                <div class="card-body">
                                    <h5 class="card-title">Pasta Fresca</h5>
                                    <p class="card-text">Deliziosa pasta fatta in casa con ingredienti locali.</p>
                                    <span class="badge bg-primary">$12.99</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
                            <div class="card h-100 shadow-sm">
                                <img src="https://images.unsplash.com/photo-1548365328-9f547fb09510?auto=format&fit=crop&w=1200&q=80" class="card-img-top" alt="Pizza margherita">
                                <div class="card-body">
                                    <h5 class="card-title">Pizza Margherita</h5>
                                    <p class="card-text">Classica pizza con pomodoro, mozzarella e basilico.</p>
                                    <span class="badge bg-primary">$15.99</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="300">
                            <div class="card h-100 shadow-sm">
                                <img src="https://images.unsplash.com/photo-1551183053-bf91a1d81141?auto=format&fit=crop&w=1200&q=80" class="card-img-top" alt="Insalata Caesar">
                                <div class="card-body">
                                    <h5 class="card-title">Insalata Caesar</h5>
                                    <p class="card-text">Insalata croccante con dressing speciale.</p>
                                    <span class="badge bg-primary">$9.99</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="row">
                        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
                            <div class="card h-100 shadow-sm">
                                <img src="https://images.unsplash.com/photo-1600271886742-f049cd451bba?auto=format&fit=crop&w=1200&q=80" class="card-img-top" alt="Tiramisù">
                                <div class="card-body">
                                    <h5 class="card-title">Tiramisù</h5>
                                    <p class="card-text">Dolce italiano classico con caffè e mascarpone.</p>
                                    <span class="badge bg-primary">$7.99</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
                            <div class="card h-100 shadow-sm">
                                <img src="https://images.unsplash.com/photo-1514362545857-3bc16c4c76a6?auto=format&fit=crop&w=1200&q=80" class="card-img-top" alt="Vino rosso">
                                <div class="card-body">
                                    <h5 class="card-title">Vino Rosso</h5>
                                    <p class="card-text">Selezione di vini pregiati per accompagnare i tuoi pasti.</p>
                                    <span class="badge bg-primary">$25.99</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="300">
                            <div class="card h-100 shadow-sm">
                                <img src="https://images.unsplash.com/photo-1542736667-069246bdbc84?auto=format&fit=crop&w=1200&q=80" class="card-img-top" alt="Antipasto misto">
                                <div class="card-body">
                                    <h5 class="card-title">Antipasto Misto</h5>
                                    <p class="card-text">Selezione di salumi e formaggi locali.</p>
                                    <span class="badge bg-primary">$14.99</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#menuCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#menuCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <div class="text-center mt-4">
            <a href="{{ page_url('menus') }}" class="btn btn-primary btn-lg">Vai al Menu</a>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="cta py-5" data-aos="fade-up">
    <div class="container text-center">
        <h2 class="mb-4" style="font-family: 'Playfair Display', serif;">Pronto per Ordinare?</h2>
        <p class="lead mb-4">Scegli i tuoi piatti preferiti e ordina comodamente da casa.</p>
        <a href="{{ url('/checkout') }}" class="btn btn-primary btn-lg">Inizia l'Ordine</a>
    </div>
</section>

<!-- Reviews Section -->
<section id="reviews" class="py-5 bg-light" data-aos="fade-up">
    <div class="container">
        <h2 class="text-center mb-5" style="font-family: 'Playfair Display', serif;">Recensioni dei Clienti</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <p class="mb-3">“Pasta eccezionale e servizio impeccabile. Tornerò sicuramente!”</p>
                        <div class="small text-muted">— Giulia R.</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <p class="mb-3">“La migliore pizza Margherita della città. Ingredienti freschissimi.”</p>
                        <div class="small text-muted">— Marco L.</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <p class="mb-3">“Consegna puntuale e piatti caldi. 5 stelle!”</p>
                        <div class="small text-muted">— Sara P.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>

<!-- Hours Section -->
<section id="hours" class="py-5" data-aos="fade-up">
    <div class="container">
        <h2 class="text-center mb-4" style="font-family: 'Playfair Display', serif;">Orari di Apertura</h2>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between"><span>Lun - Ven</span><strong>12:00 – 15:00, 19:00 – 23:00</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>Sabato</span><strong>12:00 – 15:30, 19:00 – 23:30</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>Domenica</span><strong>12:30 – 15:30, 19:00 – 23:00</strong></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section with Map -->
<section id="contact" class="py-5 bg-light" data-aos="fade-up">
    <div class="container">
        <h2 class="text-center mb-4" style="font-family: 'Playfair Display', serif;">Contatti</h2>
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-5">
                <div class="p-4 h-100 bg-white rounded shadow-sm">
                    <h5 class="mb-3">Il Nostro Indirizzo</h5>
                    <p class="mb-1">Via Roma 123, 00100 Roma RM</p>
                    <p class="mb-1">Telefono: <a href="tel:+390612345678">+39 06 123 456 78</a></p>
                    <p class="mb-4">Email: <a href="mailto:info@tuoristorante.it">info@tuoristorante.it</a></p>
                    <a href="{{ url('/checkout') }}" class="btn btn-primary">Ordina per Consegna</a>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm">
                    <iframe title="Mappa" src="https://www.openstreetmap.org/export/embed.html?bbox=12.4833%2C41.8933%2C12.5033%2C41.9033&amp;layer=mapnik" style="border:0;" allowfullscreen loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
