<?php

if (!defined('ABSPATH')) {
    exit;
}
?>
<footer class="site-footer">
    <div class="container site-footer__inner">
        <div class="footer-col">
            <h3 class="footer-title">Selitec Capacitación</h3>
            <p>Organismo Técnico de Capacitación (OTEC) reconocido por SENCE. Certificación de Calidad NCh 2728.</p>
            <div class="social-links">
                <a href="https://www.instagram.com/selitec.cl/" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                <a href="https://www.facebook.com/selitec?fref=ts" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                <a href="https://www.linkedin.com/company/selitec/" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>
            </div>
        </div>

        <div class="footer-col">
            <h3 class="footer-title">Enlaces Rápidos</h3>
            <ul class="footer-links">
                <li><a href="<?php echo esc_url(home_url('/cursos/')); ?>">Catálogo de Cursos</a></li>
                <li><a href="<?php echo esc_url(home_url('/programacion/')); ?>">Programación Mensual</a></li>
                <li><a href="<?php echo esc_url(home_url('/nivelacion/')); ?>">Nivelación de Estudios</a></li>
                <li><a href="https://www.selitec.cl/elearning">Plataforma E-learning</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h3 class="footer-title">Contacto</h3>
            <ul class="contact-list">
                <li><i class="fas fa-phone" aria-hidden="true"></i> <a href="tel:+56226385307">+56 2 2638 5307</a></li>
                <li><i class="fas fa-phone" aria-hidden="true"></i> <a href="tel:+56226397059">+56 2 2639 7059</a></li>
                <li><i class="fas fa-envelope" aria-hidden="true"></i> <a href="mailto:contacto@selitec.cl">contacto@selitec.cl</a></li>
            </ul>
        </div>
    </div>
    <div class="site-footer__bottom">
        <div class="container">
            <p>&copy; <?php echo esc_html((string) gmdate('Y')); ?> Selitec Capacitación. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
