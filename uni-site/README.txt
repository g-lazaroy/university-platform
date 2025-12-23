# Διαδικτυακή Πλατφόρμα Πανεπιστημίου Ηλιούπολης

## Περιγραφή Εργασίας
Η εργασία υλοποιεί μια πλήρη web πλατφόρμα πανεπιστημίου με:
- Δημόσιες σελίδες (Αρχική, Πληροφορίες, Χάρτης)
- Σύστημα αυθεντικοποίησης (Login/Register με ειδικό κωδικό εγγραφής)
- Role-Based Dashboard (Φοιτητής / Καθηγητής)
- Διαχείριση μαθημάτων, εργασιών, υποβολών και βαθμολόγησης
- Πλήρης συγχρονισμός δεδομένων μεταξύ χρηστών

**Μέρος 1:** Δημόσιες σελίδες + Login/Register  
**Μέρος 2:** Πλήρες dashboard + RBAC + CRUD λειτουργίες

## Τεχνολογίες
- **Frontend**: HTML5, CSS3, JavaScript
- **Framework**: Bootstrap 5 (responsive UI, navbar, cards, forms)
- **Backend**: PHP 
- **Βάση Δεδομένων**: MySQL (XAMPP)
- **Χάρτης**: Leaflet.js
- **Session & RBAC**: PHP sessions + role control


## Εγκατάσταση & Εκτέλεση
1. Τοποθετήστε τον φάκελο `uni-site` στο `C:\xampp\htdocs\uni-site\`
2. Εκκινήστε XAMPP → Apache + MySQL
3. Άνοιγμα phpMyAdmin (`http://localhost/phpmyadmin`)
4. Import `db/university_db_v2.sql`
5. Άνοιγμα browser → `http://localhost/uni-site/index.html`

## Test Χρήστες
- **Φοιτητής**: `nikos@uni.gr` / `123456`
- **Καθηγητής**: `papadopoulos@uni.gr` / `prof123`

## Εγγραφή Νέου Χρήστη
- Κωδικός Φοιτητή: `STUD2025`
- Κωδικός Καθηγητή: `PROF2025`

## Δοκιμές
Δείτε το αρχείο `TESTS.md` για πλήρες σχέδιο δοκιμών (functional, RBAC, responsive, sync).

## Σημειώσεις
- Η εφαρμογή είναι πλήρως responsive (Bootstrap 5).
- Όλα τα links λειτουργούν με XAMPP (Apache).
- Upload αρχείων στο `assets/uploads/` (δικαιώματα εγγραφής).
- Συγχρονισμός δεδομένων μέσω κοινής MySQL βάσης.

