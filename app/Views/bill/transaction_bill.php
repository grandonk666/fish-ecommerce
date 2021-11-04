<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $title; ?></title>
</head>

<body style="background-color: #f9f9f9; font-family: sans-serif; margin: 0">
  <div style="width: 100%; margin: 0 auto">
    <div style="width: 100%; margin: 0; background-color: #ffffff">
      <h2 style="margin: 0; padding: 10px 0 5px 20px; font-size: 2em">
        Sunset Hotel
      </h2>
      <p style="margin: 0; padding: 5px 0 5px 20px; font-size: 1.6em">
        IDR <?= number_format($transaksi['gross_amount'], '0', '', '.'); ?>
      </p>
      <p style="margin: 0; padding: 5px 0 20px 20px; font-size: 1.2em">
        <strong><?= $transaksi['payment_type']; ?></strong>
      </p>
    </div>
    <div style="width: 100%; background-color: #dddddd; margin: 0">
      <p style="
            color: #000000;
            margin: 0;
            font-size: 0.9em;
            padding: 10px 0 10px 20px;
          ">
        ORDER ID : <?= $transaksi['order_id']; ?>
      </p>
    </div>
    <div style="width: 100%; background-color: #2eca6a; margin: 0">
      <p style="
            color: #ffffff;
            margin: 0;
            text-align: center;
            font-size: 0.9em;
            padding: 15px 0 15px 0;
          ">
        <strong>TRANSACTION SUCCESS</strong>
      </p>
    </div>
    <div style="width: 100%; margin: 0; background-color: #ffffff">
      <p style="
            color: #000000;
            margin: 0;
            font-size: 1.2em;
            padding: 30px 20px 10px 20px;
          ">
        Dear <?= $transaksi['customer_name']; ?>,
      </p>
      <p style="
            color: #000000;
            margin: 0;
            font-size: 1.2em;
            padding: 10px 20px 10px 20px;
          ">
        Your transaction was successful! You can see your order below
      </p>

      <table style="width: 100%; padding: 30px 30px 10px 30px; font-size: 1.1em">
        <thead>
          <tr>
            <th style="height: 40px; text-align: left">Item</th>
            <th style="height: 40px; text-align: right">Price</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td style="text-align: left; border-bottom: 1px solid #a1a1a1">
              <?= $transaksi['item_name']; ?>
            </td>
            <td style="text-align: right; border-bottom: 1px solid #a1a1a1">
              IDR <?= number_format($transaksi['gross_amount'], '0', '', '.'); ?>
            </td>
          </tr>
          <tr>
            <th style="height: 40px; text-align: left">TOTAL</th>
            <th style="height: 40px; text-align: right">IDR <?= number_format($transaksi['gross_amount'], '0', '', '.'); ?></th>
          </tr>
        </tbody>
      </table>

      <p style="
            color: #000000;
            margin: 0;
            font-size: 1.1em;
            padding: 30px 20px 0 20px;
          ">
        <span style="color: rgb(231, 65, 65); font-size: 1.5em">*</span>
        Please save this bill for administrative purposes later
      </p>
      <p style="
            color: #000000;
            margin: 0;
            font-size: 1.1em;
            padding: 0 20px 30px 20px;
          ">
        Thanks,
      </p>
    </div>
    <div style="width: 100%; background-color: #424242; margin: 0">
      <p style="
            color: #ffffff;
            margin: 0;
            text-align: center;
            font-size: 0.8em;
            padding: 10px 0 0 0;
          ">
        For further information, please contact:
      </p>
      <p style="
            color: #ffffff;
            margin: 0;
            text-align: center;
            font-size: 0.8em;
            padding: 0 0 10px 0;
          ">
        email:
        <span style="color: rgb(107, 139, 235)">18081010095.c@gmail.com</span>
        | phone: <span style="color: rgb(107, 139, 235)">+6285730187977</span>
      </p>
    </div>
  </div>
</body>

</html>