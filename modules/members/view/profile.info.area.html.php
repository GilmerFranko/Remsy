<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\members\view\profile.html.php    \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Vista del área "Sobre mí" de la sección "Perfil"
 *
 *
*/
?>

<div class="row">
    <div class="col s12">
        <?php if($memberData['member_id'] == $session->memberData['member_id'] && isset($session->memberData['earnings'])) { ?>
        <div class="row">
            <div class="col s6">
            <span class="text-bold">Ganancias</span>
            </div>
            <div class="col s6">
            &dollar;<?php echo $session->memberData['earnings']; ?>
            </div>
        </div>
        <hr />
        <?php } if($memberData['member_id'] == $session->memberData['member_id'] || $session->is_admod) { ?>
        <!-- CRÉDITOS -->
        <div class="row">
            <div class="col s6">
            <span class="text-bold">Cr&eacute;ditos</span>
            </div>
            <div class="col s6">
            <?php echo $memberData['coins']; ?>
            </div>
        </div>
        <hr />
        <?php } ?>
        <!-- NOMBRE COMPLETO-->
        <div class="row">
            <div class="col s6">
            <span class="text-bold">Nombre completo</span>
            </div>
            <div class="col s6">
            <?php echo $memberData['pp_full_name']; ?>
            </div>
        </div>
        <hr />
        <!-- RANGO -->
        <div class="row">
            <div class="col s6">
            Rango
            </div>
            <div class="col s6">
            <span style="color:<?php echo $memberData['g_colour']; ?>"><?php echo $memberData['g_title']; ?></span>
            </div>
        </div>
        <hr />
        <!-- SEXO -->
        <div class="row">
            <div class="col s6">
                Sexo
            </div>
            <div class="col s6">
                <?php echo $memberData['gender'];?>
            </div>
        </div>
        <hr />
    </div>
</div>