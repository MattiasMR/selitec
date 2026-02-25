<?php

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>
<main>
    <section class="hero hero--compact">
        <div class="container hero__content">
            <h1 class="hero__title">Contacto</h1>
            <p class="hero__subtitle">Estamos aquí para resolver tus dudas y ayudarte a capacitarte.</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="contact-grid">
                <div>
                    <h2 class="section-title">Información de Contacto</h2>
                    <p class="mb-4">Si tienes dudas sobre cursos, fechas o franquicia SENCE, contáctanos.</p>

                    <ul class="contact-list" style="font-size: 1.1rem; gap: 1.5rem; display: flex; flex-direction: column;">
                        <li><i class="fas fa-phone" style="color: var(--c-secondary); width: 25px;"></i> <strong>Teléfonos:</strong><br><span style="margin-left: 30px; display: block;"><a href="tel:+56226385307">+56 2 2638 5307</a></span><span style="margin-left: 30px; display: block;"><a href="tel:+56226397059">+56 2 2639 7059</a></span></li>
                        <li><i class="fas fa-envelope" style="color: var(--c-secondary); width: 25px;"></i> <strong>Email:</strong><br><span style="margin-left: 30px; display: block;"><a href="mailto:contacto@selitec.cl">contacto@selitec.cl</a></span></li>
                        <li><i class="fas fa-map-marker-alt" style="color: var(--c-secondary); width: 25px;"></i> <strong>Dirección:</strong><br><span style="margin-left: 30px; display: block;">Antonio Bellet 240, oficina 705, Providencia</span></li>
                    </ul>

                    <div class="contact-schedule">
                        <h3 class="h4 mb-2">Horario de Atención</h3>
                        <p>Lunes a Viernes: 09:00 - 18:00 hrs.</p>
                    </div>
                </div>

                <div>
                    <div class="sticky-card" style="padding: 2rem; position: static;">
                        <h2 class="h3 mb-4" style="color: var(--c-primary);">Envíanos un mensaje</h2>
                        <form class="contact-form" action="#" method="post">
                            <div class="mb-4">
                                <label for="name" style="display: block; margin-bottom: .5rem; font-weight: 500;">Nombre Completo</label>
                                <input type="text" id="name" name="name" required style="width:100%; padding:.75rem; border:1px solid var(--c-border); border-radius:var(--radius-sm);">
                            </div>
                            <div class="mb-4">
                                <label for="email" style="display: block; margin-bottom: .5rem; font-weight: 500;">Correo Electrónico</label>
                                <input type="email" id="email" name="email" required style="width:100%; padding:.75rem; border:1px solid var(--c-border); border-radius:var(--radius-sm);">
                            </div>
                            <div class="mb-4">
                                <label for="phone" style="display: block; margin-bottom: .5rem; font-weight: 500;">Teléfono</label>
                                <input type="tel" id="phone" name="phone" style="width:100%; padding:.75rem; border:1px solid var(--c-border); border-radius:var(--radius-sm);">
                            </div>
                            <div class="mb-4">
                                <label for="subject" style="display: block; margin-bottom: .5rem; font-weight: 500;">Asunto</label>
                                <select id="subject" name="subject" style="width:100%; padding:.75rem; border:1px solid var(--c-border); border-radius:var(--radius-sm);">
                                    <option value="cotizacion">Cotización de Curso</option>
                                    <option value="empresa">Consulta Empresa</option>
                                    <option value="nivelacion">Nivelación de Estudios</option>
                                    <option value="otro">Otro</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="message" style="display: block; margin-bottom: .5rem; font-weight: 500;">Mensaje</label>
                                <textarea id="message" name="message" rows="4" required style="width:100%; padding:.75rem; border:1px solid var(--c-border); border-radius:var(--radius-sm);"></textarea>
                            </div>
                            <button type="submit" class="btn btn--primary" style="width:100%;">Enviar Mensaje</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" style="padding-top: 0;">
        <div class="container">
            <h2 class="section-title text-center mb-4">Nuestra Ubicación</h2>
            <div style="border-radius: var(--radius-md); overflow: hidden; box-shadow: var(--shadow-md);">
                <iframe src="https://maps.google.com/maps?q=Antonio%20Bellet%20240%2C%20oficina%20705%2C%20Providencia&t=&z=15&ie=UTF8&iwloc=&output=embed" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>
</main>
<?php
get_footer();
