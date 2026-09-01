# Fendo API — Flutter
> **Local:** `http://fendo.test/api/v1` or `http://localhost/Fendo/public/api/v1`  
> **Live:** `https://yourdomain.com/api/v1` (set when building the app)

See **DEPLOY.md** for full server upload steps.

All JSON. Protected routes need:

```
Accept: application/json
Authorization: Bearer {access_token}
```

Success shape:

```json
{ "success": true, "message": "...", "data": {} }
```

---

## Auth

### Register
`POST /auth/register`  
Body: `{ "name": "...", "email": "optional@mail.com", "phone": "01712345678", "country_code": "+880", "password": "secret12", "id_token": "<firebase idToken after SMS>" }`  
SMS OTP is required once at register. After that, sign in with phone + password only.

### Login
`POST /auth/login`  
Body: `{ "phone": "01712345678", "country_code": "+880", "password": "secret12" }`  
No OTP.

### Forgot password
`POST /auth/send-otp` `{ "phone": "...", "country_code": "+880", "purpose": "register"|"reset" }`  
Then Firebase SMS. Then:  
`POST /auth/reset-password` `{ "phone": "...", "country_code": "+880", "password": "newpass", "id_token": "<firebase idToken>" }`

### Firebase phone OTP
`POST /auth/firebase`  
After the Flutter app verifies SMS with Firebase Auth, send:  
`{ "id_token": "<firebase idToken>", "phone": "01712345678", "country_code": "+880" }`  
Returns the same `user` + `access_token` as verify-otp.

### Send OTP (server fallback)
`POST /auth/send-otp`  
Body: `{ "phone": "9296876662", "country_code": "+1" }`  
Local response includes `otp`.

### Verify OTP
`POST /auth/verify-otp`  
Body: `{ "phone": "9296876662", "country_code": "+1", "otp": "024753", "device_name": "iPhone" }`  
Returns `user`, `access_token`, `is_new_user`.  
If `is_new_user` is true → show **First login** screen.

### Complete profile (First login)
`POST /auth/complete-profile` **Auth**  
Body: `{ "first_name": "Mohammad", "last_name": "Parvez", "gender": "male" }`  
`gender`: `male` | `female` | `other`

### Me / Logout
`GET /auth/me` **Auth**  
`POST /auth/logout` **Auth**

---

## Summary (home)

`GET /summary` **Auth**

```json
{
  "i_owe_total": 0,
  "people_owe_me_total": 300,
  "i_owe": [],
  "people_owe_me": [{ "id": 1, "name": "Erlich", "balance": 300, "direction": "owes_you" }]
}
```

`GET /search?q=tk` **Auth** — search contacts for the summary search bar.

---

## Contacts (Create Loan picker)

`GET /contacts?search=` **Auth**  
`POST /contacts` **Auth** `{ "name": "TK(Kings cash & Carry- Bronx, NY)", "phone": "+13132724900" }`  
`POST /contacts/sync` **Auth** `{ "contacts": [{ "name": "Sister", "phone": "5551112222" }] }`  
`GET /contacts/{id}` **Auth** — contact detail (`has_open_loan`, `balance_label`, `is_evenly_user`)

Green **evenly** badge = `is_evenly_user: true`.

---

## Loans (Lend / Borrow / Pay / Close)

`POST /loans` **Auth**

```json
{ "contact_id": 1, "type": "lend", "amount": 300, "description": "fishing rod" }
```

`type`: `lend` | `borrow`

`POST /contacts/{id}/pay` **Auth** `{ "amount": 40, "description": "partial" }`  
`POST /contacts/{id}/close` **Auth** — Close debt (zeros the open loan)

Balance: **positive = they owe you**, **negative = you owe them**.

---

## History

`GET /history?page=1&contact_id=&type=` **Auth**  
Empty list → show “Transactions history is empty”.

---

## Notifications & settings

`GET /notifications` **Auth**  
`GET /notifications/unread-count` **Auth**  
`PUT /notifications/{id}/read` **Auth**  
`POST /notifications/read-all` **Auth**

`GET /profile` **Auth**  
`PUT /profile` **Auth** `{ "name", "email", "password?" }` — password only if changing. Email optional.  
`POST /profile/avatar` **Auth** multipart form: `avatar` (jpg/png/webp, max 2MB). Returns full user with `avatar` URL.  
`DELETE /profile/avatar` **Auth** — remove photo  
`PUT /profile/fcm-token` **Auth** `{ "fcm_token": "..." }` — Enable push notifications  
`PUT /profile/notifications` **Auth** `{ "notifications_enabled": true }`

`POST /feedback` **Auth** `{ "message": "..." }`

---

## Admin panel (web)

URL: `http://fendo.test/admin/login`  
Email: `admin@gmail.com`  
Password: `12345678`

Pages: Dashboard, Users, Loans, Feedback, Profile.
