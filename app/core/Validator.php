<?php
// app/core/Validator.php - Request Validator Engine ala Laravel

class Validator {
    private $data = [];
    private $rules = [];
    private $errors = [];
    private $validatedData = [];

    public function __construct(array $data, array $rules) {
        $this->data = $data;
        $this->rules = $rules;
        $this->validate();
    }

    /**
     * Static factory helper: Validator::make($data, $rules)
     */
    public static function make(array $data, array $rules): self {
        return new self($data, $rules);
    }

    /**
     * Jalankan proses validasi berdasarkan aturan
     */
    private function validate() {
        foreach ($this->rules as $field => $ruleString) {
            $rulesList = is_array($ruleString) ? $ruleString : explode('|', $ruleString);
            $value = $this->data[$field] ?? null;
            $fieldLabel = ucfirst(str_replace(['_', '-'], ' ', $field));

            foreach ($rulesList as $rule) {
                $param = null;
                if (strpos($rule, ':') !== false) {
                    [$ruleName, $param] = explode(':', $rule, 2);
                } else {
                    $ruleName = $rule;
                }

                switch ($ruleName) {
                    case 'required':
                        if ($value === null || trim((string)$value) === '') {
                            $this->addError($field, "Field {$fieldLabel} wajib diisi.");
                        }
                        break;

                    case 'min':
                        if (is_numeric($value)) {
                            if ((float)$value < (float)$param) {
                                $this->addError($field, "Field {$fieldLabel} minimal harus bernilai {$param}.");
                            }
                        } else {
                            if (mb_strlen((string)$value) < (int)$param) {
                                $this->addError($field, "Field {$fieldLabel} minimal harus {$param} karakter.");
                            }
                        }
                        break;

                    case 'max':
                        if (is_numeric($value)) {
                            if ((float)$value > (float)$param) {
                                $this->addError($field, "Field {$fieldLabel} maksimal bernilai {$param}.");
                            }
                        } else {
                            if (mb_strlen((string)$value) > (int)$param) {
                                $this->addError($field, "Field {$fieldLabel} tidak boleh lebih dari {$param} karakter.");
                            }
                        }
                        break;

                    case 'numeric':
                        if ($value !== null && $value !== '' && !is_numeric($value)) {
                            $this->addError($field, "Field {$fieldLabel} harus berupa angka.");
                        }
                        break;

                    case 'integer':
                        if ($value !== null && $value !== '' && filter_var($value, FILTER_VALIDATE_INT) === false) {
                            $this->addError($field, "Field {$fieldLabel} harus berupa bilangan bulat (integer).");
                        }
                        break;

                    case 'email':
                        if ($value !== null && $value !== '' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            $this->addError($field, "Field {$fieldLabel} harus berformat email yang valid.");
                        }
                        break;

                    case 'string':
                        if ($value !== null && !is_string($value)) {
                            $this->addError($field, "Field {$fieldLabel} harus berupa teks.");
                        }
                        break;

                    case 'in':
                        $allowed = explode(',', $param);
                        if ($value !== null && !in_array($value, $allowed)) {
                            $this->addError($field, "Field {$fieldLabel} harus salah satu dari: " . implode(', ', $allowed));
                        }
                        break;
                }
            }

            // Sanitasi data jika valid
            if (!isset($this->errors[$field])) {
                if (is_string($value)) {
                    $this->validatedData[$field] = htmlspecialchars(trim($value));
                } else {
                    $this->validatedData[$field] = $value;
                }
            }
        }
    }

    private function addError(string $field, string $message) {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }
        $this->errors[$field][] = $message;
    }

    public function fails(): bool {
        return !empty($this->errors);
    }

    public function passes(): bool {
        return empty($this->errors);
    }

    /**
     * Dapatkan semua pesan error dalam bentuk flat array
     */
    public function errors(): array {
        $flat = [];
        foreach ($this->errors as $messages) {
            foreach ($messages as $msg) {
                $flat[] = $msg;
            }
        }
        return $flat;
    }

    /**
     * Dapatkan pesan error pertama
     */
    public function first(): ?string {
        $all = $this->errors();
        return $all[0] ?? null;
    }

    /**
     * Dapatkan data yang telah tervalidasi dan disanitasi
     */
    public function validated(): array {
        return $this->validatedData;
    }
}
