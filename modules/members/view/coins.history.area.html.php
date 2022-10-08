<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\members\view\coins.html.php      \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Vista del área "Historial de compras" de Créditos
 *
 *
*/
?>
<div id="contentCoinsHistory">
    <table class="striped responsive-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cr&eacute;ditos</th>
                <th>Precio</th>
                <th>Estado</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($purchases)) { while( $buy = $purchases->fetch_assoc() ) { ?>
            <tr id="buy_<?php echo $buy['id']; ?>">
                <td>#<?php echo $buy['id']; ?>
                </td>
                <td><?php echo $buy['coins']; ?></td>
                <!--<td>&dollar;<?php echo number_format(($buy['price'] /100), 2, '.', ' '); ?></td>-->
                <td>&dollar;<?php echo $buy['price']; ?></td>
                <td><?php echo ($buy['status'] == 'paid') ? 'Pagado' : ($buy['status'] == 'success' ? 'Procesado' : 'Incompleto') ; ?></td>
                <td><?php echo Core::model('date', 'core')->getTimeAgo($buy['date']); ?></td>
            </tr>
            <?php } }else echo '<tr><td colspan="5">No has comprado</td></tr>'; ?>
        </tbody>
    </table>
</div>