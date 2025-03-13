# Xploit@shell

Xploit@shell is an enhanced version of [P0wny Shell](https://github.com/flozz/p0wny-shell), a lightweight PHP-based web shell that allows remote command execution via a web interface.
This version significantly improves security by implementing two key enhancements:

## 🔑 Key Features:

Default Features:

- Command history (using arrow keys `↑` `↓`)
- Auto-completion of command and file names (using `Tab` key)
- Navigate on the remote file-system (using `cd` command)
- Upload a file to the server (using upload `<destination_file_name>` command)
- Download a file from the server (using download `<file_name>` command)

---

### 1. Bypassing Antivirus Detection

This shell includes techniques to evade detection by antivirus software, making it harder to flag as malicious. These improvements ensure continued functionality even in environments with active security measures.

### 2. Password Protection & GET Parameter Verification

Unlike the original P0wny Shell, this version **restricts access** by requiring:

- A correct password (hashed & encoded).
- A specific GET parameter.

Users must provide both in the URL to access the shell:

```bash
http://example.com/shell.php?h=<encoded_password>
```

Without these parameters, access is **completely denied**, ensuring that only authorized users can execute commands.

Additionally, **you can rename the GET parameter** (`h`) for even stronger security.

---

## ⚙️ Usage:

### 1. Generating a Secure Password

To generate a new password hash, use the following PHP code:

```php
echo password_hash('your_password', PASSWORD_ARGON2I);
echo base64_encode(urlencode('your_password'));
```

> **Default password:** `admin` (Change it)

### 2. Avoiding Antivirus Detection

Since `shell.php` is **often detected** by security tools, it is recommended to rename the file to something **less obvious**.

---

## 🔒 Security Measures

- The shell will **not** be accessible unless the correct parameters are provided.
- Even if an attacker finds the URL, they **cannot** access the shell without the correct **password** and **GET parameter**.
- To increase security, rename the GET parameter (`h`) to something **unpredictable**.

---

## ⚠️ Disclaimer

This tool is intended **exclusively** for **ethical hacking** and **penetration testing**.  
Only use it in environments where you have explicit authorization.
