<?php
namespace Core;

// Kelas Validator untuk memvalidasi input data
class Validator
{
    // Menyimpan data yang akan divalidasi
    private array $data;
    // Menyimpan daftar error validasi
    private array $errors = [];

    // Constructor menerima array data input
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    // Aturan validasi: Wajib diisi (required)
    public function required(string $field): self
    {
        $value = trim((string)($this->data[$field] ?? ''));
        // Jika kosong, catat error
        if ($value === '') {
            $this->errors[$field] = ['required'];
        }
        // Kembalikan instance untuk chaining method
        return $this;
    }

    // Aturan validasi: Format Email
    public function email(string $field): self
    {
        $value = trim((string)($this->data[$field] ?? ''));
        // Jika tidak kosong dan bukan format email valid
        if ($value !== '' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = ['email'];
        }
        return $this;
    }

    // Aturan validasi: Panjang minimal karakter
    public function min(string $field, int $min): self
    {
        $value = trim((string)($this->data[$field] ?? ''));
        // Jika panjang string kurang dari minimal
        if ($value !== '' && mb_strlen($value) < $min) {
            $this->errors[$field] = ['min'];
        }
        return $this;
    }

    // Aturan validasi: Nilai harus ada dalam daftar yang diizinkan (enum)
    public function in(string $field, array $allowed): self
    {
        $value = trim((string)($this->data[$field] ?? ''));
        // Jika nilai tidak ada dalam array allowed
        if ($value !== '' && !in_array($value, $allowed, true)) {
            $this->errors[$field] = ['in'];
        }
        return $this;
    }

    // Mengecek apakah ada validasi yang gagal
    public function fails(): bool
    {
        return !empty($this->errors);
    }

    // Mengambil semua pesan error
    public function errors(): array
    {
        return $this->errors;
    }
}
