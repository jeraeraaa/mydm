document.addEventListener('DOMContentLoaded', function() {
    const nimField = document.getElementById('id_anggota');
    const nimError = document.getElementById('nimError');
    const namaField = document.getElementById('nama_anggota');
    const namaError = document.getElementById('namaError');
    const emailField = document.getElementById('email');
    const emailError = document.getElementById('emailError');

    // Fungsi debounce untuk menunda pemanggilan fungsi
    function debounce(func, delay) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), delay);
        };
    }

    // Validasi NIM secara langsung saat pengguna mengetik
    nimField.addEventListener('input', debounce(function() {
        const nimValue = nimField.value;
        nimError.textContent = ''; // Reset error

        // Validasi panjang NIM
        if (nimValue.length !== 9 || isNaN(nimValue)) {
            nimError.textContent = 'NIM harus berupa 9 digit angka.';
            nimField.classList.add('is-invalid');
            return; // Hentikan fungsi jika tidak valid
        } else {
            nimField.classList.remove('is-invalid');
        }

        // Validasi kode prodi dari NIM
        const kodeProdi = nimValue.substring(0, 3);
        const validProdi = [
            '115', '125', '205', '315', '325', '345', '405', '515',
            '525', '535', '545', '615', '625', '705', '825', '915'
        ];
        if (!validProdi.includes(kodeProdi)) {
            nimError.textContent = 'NIM tidak sesuai dengan kode prodi yang valid.';
            nimField.classList.add('is-invalid');
            return; // Hentikan fungsi jika tidak valid
        }

        // Periksa apakah NIM sudah ada di database
        checkNimExists(nimValue);
    }, 500));

    function checkNimExists(nim) {
        fetch(`/check-nim?nim=${nim}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    nimError.textContent = 'NIM ini sudah terdaftar.';
                    nimField.classList.add('is-invalid');
                } else {
                    nimError.textContent = '';
                    nimField.classList.remove('is-invalid');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    namaField.addEventListener('input', function() {
        // Validasi hanya huruf dan spasi
        const regex = /^[A-Za-z\s]*$/;
        if (!regex.test(namaField.value)) {
            namaError.textContent = "Nama hanya boleh berisi huruf dan spasi.";
            namaField.classList.add('is-invalid');
        } else {
            namaError.textContent = "";
            namaField.classList.remove('is-invalid');
        }
    });

    // Validasi Email secara langsung saat pengguna mengetik
    emailField.addEventListener('input', debounce(function() {
        const emailValue = emailField.value;
        emailError.textContent = ''; // Reset error

        // Validasi format email
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailPattern.test(emailValue)) {
            emailError.textContent = 'Format email tidak valid.';
            emailField.classList.add('is-invalid');
            return; // Hentikan fungsi jika format tidak valid
        } else {
            emailField.classList.remove('is-invalid');
        }

        // Periksa apakah Email sudah ada di database
        checkEmailExists(emailValue);
    }, 500));

    function checkEmailExists(email) {
        fetch(`/check-email?email=${email}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    emailError.textContent = 'Email sudah terdaftar.';
                    emailField.classList.add('is-invalid');
                } else {
                    emailError.textContent = '';
                    emailField.classList.remove('is-invalid');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }


    // Validasi Nomor HP secara langsung saat pengguna mengetik
    document.getElementById('no_hp').addEventListener('input', function() {
        const noHpField = document.getElementById('no_hp');
        const noHpValue = noHpField.value;
        const noHpError = document.getElementById('noHpError');

        if (!/^\d{10,13}$/.test(noHpValue)) {
            noHpError.textContent = 'Nomor HP harus terdiri dari 10-13 digit angka.';
            noHpField.classList.add('is-invalid');
        } else {
            noHpError.textContent = '';
            noHpField.classList.remove('is-invalid');
        }
    });

    // Validasi Tanggal Lahir secara langsung saat pengguna memilih tanggal
    document.getElementById('tanggal_lahir').addEventListener('change', function() {
        const tanggalLahirField = document.getElementById('tanggal_lahir');
        const tanggalLahirValue = new Date(tanggalLahirField.value);
        const today = new Date();
        const age = today.getFullYear() - tanggalLahirValue.getFullYear();
        const ageError = document.getElementById('tanggalLahirError');

        if (age < 17) {
            ageError.textContent = 'Anggota harus berusia minimal 17 tahun.';
            tanggalLahirField.classList.add('is-invalid');
        } else {
            ageError.textContent = '';
            tanggalLahirField.classList.remove('is-invalid');
        }
    });
});
