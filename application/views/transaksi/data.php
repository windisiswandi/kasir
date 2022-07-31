
<?php foreach($data as $t) : ?>
    <?php
        $total = ($t["hrg_jual"] * $t['jml_beli']) - $t['diskon'];
    ?>  
    <tr>
        <td><?= $t["nama_produk"]; ?></td>
        <td><?= $t["jml_beli"]; ?></td>
        <td><?= "Rp " . number_format($t["hrg_jual"],2,',','.'); ?></td>
        <td><?= "Rp ".number_format($t['diskon'], 2,',','.'); ?></td>
        <td><?= "Rp ".number_format($total, 2,',','.'); ?></td>
        
        <td class="text-center text-danger" onclick="deleteTransaksiItem(<?= $t['id_item'] ?>)"><i class="fas fa-window-close"></i></a></td>
    </tr>
<?php endforeach; ?>