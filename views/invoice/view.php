<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>


<table class="table">
  <th></th>
  <th></th>
  <tr>
    <td>Previous Lease Rent</td>
    <td><?= $previousLeaseRent ?></td>
  </tr>

  <tr>
    <td>Previous SGST Amount</td>
    <td><?= $previousSGSTAmount ?></td>
  </tr>

  <tr>
    <td>Previous CGST Amount</td>
    <td><?= $previousCGSTAmount ?></td>
  </tr>

  <tr>
    <td> Previous Total Tax </td>
    <td><?= $previousTotalTax ?></td>
  </tr>

  <tr>
    <td> Penal Interest </td>
    <td><?= $penalInterest ?></td>
  </tr>

  <tr>
    <td>  Previous Due Total  </td>
    <td> <?= $previousDueTotal ?> </td>
  </tr>

  <tr>
    <td>  Current Lease Rent </td>
    <td> <?= $currentLeaseRent ?> </td>
  </tr>

  <tr>
    <td>  Current CGST Amount </td>
    <td> <?= $currentCGSTAmount ?>  </td>
  </tr>

  <tr>
    <td>  Current SGST Amount </td>
    <td> <?= $currentSGSTAmount ?>  </td>
  </tr>

  <tr>
    <td>  Current Total Tax </td>
    <td> <?= $currentTotalTax ?>  </td>
  </tr>

  <tr>
    <td>  Current Due Total </td>
    <td> <?= $currentDueTotal ?>  </td>
  </tr>

  <tr>
    <td>  Final Total ( C = A + B) </td>
    <td> <?= $currentDueTotal + $previousDueTotal ?>  </td>
  </tr>


</table>
