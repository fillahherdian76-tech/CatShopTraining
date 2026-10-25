<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nilai Mahasiswa</title>
    <style>
      * {
        box-sizing: border-box;
      }
      body {
        background-color: #dde8ec;
        font-family: "Segoe UI", Arial, sans-serif;
        color: #14263a;
      }
      h1 {
        margin-bottom: 30px;
      }
      .container {
        display: flex;
        flex-direction: column;
        background-color: white;
        width: 35%;
        margin: 40px auto;
        padding: 20px;
        justify-content: center;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(20, 38, 58, 0.15);
      }
      .input {
        display: flex;
        flex-direction: column;
        margin: 10px 0;
      }
      label {
        margin-bottom: 5px;
        font-weight: 600;
      }
      input {
        width: 100%;
        padding: 8px;
        border: 2px solid #c3d1d9;
        border-radius: 8px;
      }
      input:focus {
        outline: none;
        border-color: #2457f5;
      }
      .button {
        width: 100%;
        margin: 10px 0;
        padding: 10px;
        background: #14263a;
        border-radius: 8px;
        cursor: pointer;
        border: none;
        color: white;
        font-weight: bold;
      }
      .button:hover {
        background-color: #2457f5;
      }
      #hasil {
        margin-top: 15px;
        background: #f4f8fa;
        padding: 10px;
        border: 2px dashed #c3d1d9;
        border-radius: 8px;
        text-align: left;
      }
      #hasil b {
        background: #ffd84d;
        padding: 2px 6px;
      }
    </style>
  </head>

  <body>
    <center>
      <h1>Form Nilai Mahasiswa</h1>
      <div class="container">
        <form id="formNilai">
          <div class="input">
            <label for="nama">Nama Mahasiswa</label>
            <input type="text" id="nama" required />
          </div>

          <div class="input">
            <label for="tugas">Nilai Tugas (30%)</label>
            <input type="number" id="tugas" min="0" max="100" required />
          </div>

          <div class="input">
            <label for="uts">Nilai UTS (30%)</label>
            <input type="number" id="uts" min="0" max="100" required />
          </div>

          <div class="input">
            <label for="uas">Nilai UAS (40%)</label>
            <input type="number" id="uas" min="0" max="100" required />
          </div>

          <input type="submit" class="button" value="Hitung Nilai" />
          <input type="reset" class="button" value="Hapus" id="btnReset" />

          <div id="hasil">Hasil perhitungan akan tampil di sini.</div>
        </form>
      </div>
    </center>

    <script>
      const form = document.getElementById("formNilai");
      const hasil = document.getElementById("hasil");

      form.addEventListener("submit", function (e) {
        e.preventDefault();

        const nama = document.getElementById("nama").value;
        const tugas = parseFloat(document.getElementById("tugas").value);
        const uts = parseFloat(document.getElementById("uts").value);
        const uas = parseFloat(document.getElementById("uas").value);

        const akhir = tugas * 0.3 + uts * 0.3 + uas * 0.4;

        let grade;
        if (akhir >= 85) grade = "A";
        else if (akhir >= 70) grade = "B";
        else if (akhir >= 60) grade = "C";
        else if (akhir >= 50) grade = "D";
        else grade = "E";

        const status = akhir >= 60 ? "LULUS" : "TIDAK LULUS";

        hasil.innerHTML =
          "Nama : " + nama.replace(/</g, "&lt;") + "<br>" +
          "Nilai Akhir : " + akhir.toFixed(1) + "<br>" +
          "Grade : " + grade + "<br>" +
          "Status : <b>" + status + "</b>";
      });

      form.addEventListener("reset", function () {
        hasil.innerHTML = "Hasil perhitungan akan tampil di sini.";
      });
    </script>
  </body>
</html>