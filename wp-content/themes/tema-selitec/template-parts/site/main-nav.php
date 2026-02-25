<?php

if (!defined('ABSPATH')) {
    exit;
}

$items = array(
    array('label' => 'Inicio', 'path' => '/'),
    array('label' => 'Cursos', 'path' => '/cursos/'),
    array('label' => 'Programación Mensual', 'path' => '/programacion/'),
    array('label' => 'Nivelación de Estudios', 'path' => '/nivelacion/'),
    array('label' => 'Empresa', 'path' => '/empresa/'),
    array('label' => 'Clientes', 'path' => '/clientes/'),
    array('label' => 'Contacto', 'path' => '/contacto/'),
);
?>
<nav id="main-nav" class="main-nav">
    <ul class="main-nav__list">
        <?php foreach ($items as $item) : ?>
            <?php $aria = tema_selitec_nav_aria_current($item['path']); ?>
            <li>
                <a href="<?php echo esc_url(home_url($item['path'])); ?>" class="<?php echo esc_attr(tema_selitec_nav_class($item['path'])); ?>"<?php echo $aria ? ' aria-current="page"' : ''; ?>><?php echo esc_html($item['label']); ?></a>
            </li>
        <?php endforeach; ?>
        <li>
            <a href="https://www.selitec.cl/elearning" class="<?php echo esc_attr(tema_selitec_nav_class('', true)); ?>">Aula Virtual</a>
        </li>
    </ul>
</nav>
