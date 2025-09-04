<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= base_url('img/lambang-kabupaten-sambas.png') ?>">
    <title>Cetak Data Sekolah</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
        }

        .container {
            width: 95%;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .text-center {
            text-align: center;
        }

        .no-print {
            text-align: center;
            margin-top: 20px;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                margin: 0;
            }

            .container {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1><?= esc($title) ?></h1>
        <p>Dicetak pada: <?= date('d F Y, H:i:s') ?></p>

        <table>
            <thead>
                <tr>
                    <th class="text-center" width="5%">No</th>
                    <th>Nama Sekolah</th>
                    <th>NPSN</th>
                    <th>Jenjang</th>
                    <th>Status</th>
                    <th>Kecamatan</th>
                    <th>Desa</th>
                    <th>Alamat</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($sekolah)) : ?>
                    <?php $no = 1; ?>
                    <?php foreach ($sekolah as $row) : ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= esc($row['nama_sekolah']) ?></td>
                            <td><?= esc($row['npsn']) ?></td>
                            <td><?= esc($row['nama_jenjang']) ?></td>
                            <td><?= esc($row['status']) ?></td>
                            <td><?= esc($row['nama_kecamatan']) ?></td>
                            <td><?= esc($row['nama_desa']) ?></td>
                            <td><?= esc($row['alamat']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data untuk ditampilkan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="no-print">
            <button onclick="window.print()">Cetak Halaman</button>
        </div>
    </div>

    <script>
        // Otomatis membuka dialog print saat halaman dimuat
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>