<!-- FILE: index.php -->

<?php
include 'koneksi.php';

$data = mysqli_query($conn, "SELECT * FROM reminders ORDER BY tanggal DESC, jam ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Shift Reminder</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <h1>Smart Shift Reminder</h1>

    <form action="simpan.php" method="POST">

        <label>Nomor Bed / Pasien</label>
        <input type="text" name="bed" required>

        <label>Tindakan</label>
        <input type="text" name="action" required>

        <label>Tanggal</label>
        <input type="date" name="date" required>

        <label>Jam</label>
        <input type="time" name="time" required>

        <label>Shift</label>
        <select name="shift">
            <option>Pagi</option>
            <option>Sore</option>
            <option>Malam</option>
        </select>

        <button type="submit">Simpan Reminder</button>

    </form>

    <table>

        <tr>
            <th>Bed</th>
            <th>Tindakan</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Shift</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($data)) { ?>

        <tr>

            <td><?php echo $row['bed']; ?></td>

            <td><?php echo $row['action_name']; ?></td>

            <td><?php echo $row['tanggal']; ?></td>

            <td><?php echo $row['jam']; ?></td>

            <td><?php echo $row['shift_name']; ?></td>

            <td class="<?php echo $row['status'] == 'Pending' ? 'status-pending' : 'status-selesai'; ?>">
                <?php echo $row['status']; ?>
            </td>

            <td>

                <a href="selesai.php?id=<?php echo $row['id']; ?>"
                   class="btn selesai">

                    Selesai

                </a>

                <a href="hapus.php?id=<?php echo $row['id']; ?>"
                   class="btn hapus"
                   onclick="return confirm('Yakin ingin menghapus reminder ini?')">

                    Hapus

                </a>

            </td>

        </tr>

        <?php } ?>

    </table>

</div>

<script>

if ('Notification' in window) {

    Notification.requestPermission()
    .then(permission => {

        console.log(permission);

    });

}

function checkReminder() {

    const rows = document.querySelectorAll('table tr');

    const now = new Date();

    let jam =
        String(now.getHours()).padStart(2, '0') + ':' +
        String(now.getMinutes()).padStart(2, '0');

    let tanggal = now.toISOString().split('T')[0];

    rows.forEach((row, index) => {

        if(index === 0) return;

        const rowTanggal =
            row.cells[2].innerText.trim();

        const rowJam =
            row.cells[3].innerText.trim().substring(0,5);

        const tindakan =
            row.cells[1].innerText;

        const bed =
            row.cells[0].innerText;

        const status =
            row.cells[5].innerText.trim();

        if (
            rowTanggal === tanggal &&
            rowJam === jam &&
            status === 'Pending'
        ) {

            if (Notification.permission === 'granted') {

                new Notification(
                    'Smart Shift Reminder',
                    {
                        body: bed + ' - ' + tindakan,
                        icon: 'https://cdn-icons-png.flaticon.com/512/2966/2966486.png'
                    }
                );

            }

            alert('Reminder: ' + bed + ' - ' + tindakan);

        }

    });

}

setInterval(checkReminder, 10000);

</script>

</body>
</html>