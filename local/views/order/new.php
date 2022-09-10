<?php
/**
 * @var array $data
 */

?>

<table style="border-collapse:collapse;border-left-color:#dddddd;border-left-style:solid;border-left-width:1px;border-top-color:#dddddd;border-top-style:solid;border-top-width:1px;margin-bottom:20px;width:300px">
    <tr>
        <td colspan="2" style="background-color:#efefef;border-bottom-color:#dddddd;border-bottom-style:solid;border-bottom-width:1px;border-right-color:#dddddd;border-right-style:solid;border-right-width:1px;color:#222222;font-size:12px;font-weight:bold;padding:7px;text-align:left">
            Данные клиента
        </td>
    </tr>
    <tr>
        <td style="border-bottom-color:#dddddd;border-bottom-style:solid;border-bottom-width:1px;border-right-color:#dddddd;border-right-style:solid;border-right-width:1px;font-size:12px;padding:7px;text-align:left">
            <b>Имя</b></td>
        <td style="border-bottom-color:#dddddd;border-bottom-style:solid;border-bottom-width:1px;border-right-color:#dddddd;border-right-style:solid;border-right-width:1px;font-size:12px;padding:7px;text-align:left">
            <?= $name ?></td>
    </tr>
    <tr>
        <td style="border-bottom-color:#dddddd;border-bottom-style:solid;border-bottom-width:1px;border-right-color:#dddddd;border-right-style:solid;border-right-width:1px;font-size:12px;padding:7px;text-align:left">
            <b>Телефон</b></td>
        <td style="border-bottom-color:#dddddd;border-bottom-style:solid;border-bottom-width:1px;border-right-color:#dddddd;border-right-style:solid;border-right-width:1px;font-size:12px;padding:7px;text-align:left">
            <?= $phone ?></td>
    </tr>
</table>

<table  style="border-collapse:collapse;border-left-color:#dddddd;border-left-style:solid;border-left-width:1px;border-top-color:#dddddd;border-top-style:solid;border-top-width:1px;margin-bottom:20px;width:800px">
    <tr>
        <td colspan="5" style="background-color:#efefef;border-bottom-color:#dddddd;border-bottom-style:solid;border-bottom-width:1px;border-right-color:#dddddd;border-right-style:solid;border-right-width:1px;color:#222222;font-size:12px;font-weight:bold;padding:7px;text-align:left">
            Товары
        </td>
    </tr>
    <tr>
        <td style="border-bottom-color:#dddddd;border-bottom-style:solid;border-bottom-width:1px;border-right-color:#dddddd;border-right-style:solid;border-right-width:1px;font-size:12px;padding:7px;text-align:left">
            Название</td>
        <td style="border-bottom-color:#dddddd;border-bottom-style:solid;border-bottom-width:1px;border-right-color:#dddddd;border-right-style:solid;border-right-width:1px;font-size:12px;padding:7px;text-align:left">
            Технология</td>
        <td style="border-bottom-color:#dddddd;border-bottom-style:solid;border-bottom-width:1px;border-right-color:#dddddd;border-right-style:solid;border-right-width:1px;font-size:12px;padding:7px;text-align:left">
            Узор</td>
        <td style="border-bottom-color:#dddddd;border-bottom-style:solid;border-bottom-width:1px;border-right-color:#dddddd;border-right-style:solid;border-right-width:1px;font-size:12px;padding:7px;text-align:left">
            Упаковка</td>
        <td style="border-bottom-color:#dddddd;border-bottom-style:solid;border-bottom-width:1px;border-right-color:#dddddd;border-right-style:solid;border-right-width:1px;font-size:12px;padding:7px;text-align:left">
            Количество</td>
    </tr>
    <?php foreach ($basket as $item) {?>
    <tr>
        <td style="border-bottom-color:#dddddd;border-bottom-style:solid;border-bottom-width:1px;border-right-color:#dddddd;border-right-style:solid;border-right-width:1px;font-size:12px;padding:7px;text-align:left">
            <?php echo $item['name'] ?></td>
        <td style="border-bottom-color:#dddddd;border-bottom-style:solid;border-bottom-width:1px;border-right-color:#dddddd;border-right-style:solid;border-right-width:1px;font-size:12px;padding:7px;text-align:left">
            <?php echo $item['technology'] ?></td>
        <td style="border-bottom-color:#dddddd;border-bottom-style:solid;border-bottom-width:1px;border-right-color:#dddddd;border-right-style:solid;border-right-width:1px;font-size:12px;padding:7px;text-align:left">
            <?php echo $item['pattern'] ?></td>
        <td style="border-bottom-color:#dddddd;border-bottom-style:solid;border-bottom-width:1px;border-right-color:#dddddd;border-right-style:solid;border-right-width:1px;font-size:12px;padding:7px;text-align:left">
            <?php echo $item['package'] ?></td>
        <td style="border-bottom-color:#dddddd;border-bottom-style:solid;border-bottom-width:1px;border-right-color:#dddddd;border-right-style:solid;border-right-width:1px;font-size:12px;padding:7px;text-align:left">
            <?php echo $item['quantity'] ?></td>
    </tr>
    <?php } ?>
</table>
