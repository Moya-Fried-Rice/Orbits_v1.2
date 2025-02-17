@component('mail::message')
# Welcome to Orbits! 🚀

Hello {{ $user->name }},

Welcome to **Orbits**, the all-in-one platform for seamless faculty evaluations! We’re excited to have you on board.

### **Your Temporary Login Credentials**
- **Email:** {{ $user->email }}
- **Temporary Password:** {{ $temporaryPassword }}

🔒 **Important:** For security reasons, please log in and **change your password immediately** to secure your account.

@component('mail::button', ['url' => route('login')])
Log in to Orbits
@endcomponent

If you did not request this account, please contact our support team immediately.

Thank you,  
**The Orbits Team**
@endcomponent
