<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy — Fendo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        fendo: { DEFAULT: '#6DB33F', dark: '#5aa033', light: '#e8f6dc' }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: Inter, system-ui, sans-serif; }</style>
</head>
<body class="bg-white text-slate-800">

    <header class="sticky top-0 z-30 bg-white/90 backdrop-blur border-b border-slate-100">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-fendo text-white font-bold flex items-center justify-center">f</span>
                <span class="text-xl font-bold tracking-tight">fendo</span>
            </a>
            <nav class="hidden md:flex items-center gap-8 text-sm text-slate-600">
                <a href="/#benefits" class="hover:text-fendo">Benefits</a>
                <a href="/#features" class="hover:text-fendo">Features</a>
                <a href="/#how" class="hover:text-fendo">How it works</a>
            </nav>
            <a href="/#get-app" class="bg-fendo hover:bg-fendo-dark text-white text-sm font-semibold px-4 py-2 rounded-full">Get the app</a>
        </div>
    </header>

    <div class="max-w-4xl mx-auto px-6 py-16">
        <h1 class="text-4xl font-extrabold mb-4">Privacy Policy</h1>
        <p class="text-slate-500 mb-10">Last updated: {{ date('F j, Y') }}</p>

        <div class="prose prose-slate max-w-none">
            <section class="mb-10">
                <h2 class="text-2xl font-bold mb-3">Introduction</h2>
                <p class="text-slate-600 leading-relaxed mb-4">
                    Welcome to Fendo. We respect your privacy and are committed to protecting your personal data. 
                    This privacy policy explains how we collect, use, and safeguard your information when you use our loan tracking application.
                </p>
            </section>

            <section class="mb-10">
                <h2 class="text-2xl font-bold mb-3">Information We Collect</h2>
                <div class="text-slate-600 leading-relaxed">
                    <h3 class="text-lg font-semibold mt-4 mb-2">Personal Information</h3>
                    <ul class="list-disc pl-6 space-y-2 mb-4">
                        <li><strong>Phone Number:</strong> Used for account authentication and login via OTP</li>
                        <li><strong>Name:</strong> Your display name visible to people you share loans with</li>
                        <li><strong>Profile Photo:</strong> Optional photo to personalize your account</li>
                        <li><strong>Gender:</strong> Optional demographic information</li>
                    </ul>

                    <h3 class="text-lg font-semibold mt-4 mb-2">Financial Data</h3>
                    <ul class="list-disc pl-6 space-y-2 mb-4">
                        <li>Loan amounts (what you lend and borrow)</li>
                        <li>Transaction history and payment records</li>
                        <li>Descriptions and notes attached to loans</li>
                        <li>Contact information for people you track loans with</li>
                    </ul>

                    <h3 class="text-lg font-semibold mt-4 mb-2">Technical Data</h3>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Device information and operating system</li>
                        <li>IP address and general location data</li>
                        <li>App usage statistics and crash reports</li>
                    </ul>
                </div>
            </section>

            <section class="mb-10">
                <h2 class="text-2xl font-bold mb-3">How We Use Your Information</h2>
                <p class="text-slate-600 leading-relaxed mb-3">We use your information to:</p>
                <ul class="list-disc pl-6 space-y-2 text-slate-600">
                    <li>Provide and maintain the Fendo loan tracking service</li>
                    <li>Authenticate your account securely through OTP verification</li>
                    <li>Display your profile to people you share loans with</li>
                    <li>Send notifications about loan activity involving you</li>
                    <li>Maintain accurate records of lending and borrowing transactions</li>
                    <li>Improve our app's functionality and user experience</li>
                    <li>Prevent fraud and ensure platform security</li>
                    <li>Comply with legal obligations</li>
                </ul>
            </section>

            <section class="mb-10">
                <h2 class="text-2xl font-bold mb-3">Data Sharing and Disclosure</h2>
                <div class="text-slate-600 leading-relaxed">
                    <p class="mb-3">We do not sell your personal data. We may share your information only in the following circumstances:</p>
                    
                    <h3 class="text-lg font-semibold mt-4 mb-2">With Other Users</h3>
                    <p class="mb-4">
                        Your name, photo, and gender are visible to people you create loans with. 
                        Loan details are only shared between parties involved in specific transactions.
                    </p>

                    <h3 class="text-lg font-semibold mt-4 mb-2">Service Providers</h3>
                    <p class="mb-4">
                        We may share data with trusted third-party service providers who assist us in operating our app 
                        (e.g., cloud hosting, SMS delivery for OTP). These providers are contractually obligated to protect your data.
                    </p>

                    <h3 class="text-lg font-semibold mt-4 mb-2">Legal Requirements</h3>
                    <p>
                        We may disclose your information if required by law, court order, or government regulation, 
                        or to protect the rights, property, or safety of Fendo, our users, or others.
                    </p>
                </div>
            </section>

            <section class="mb-10">
                <h2 class="text-2xl font-bold mb-3">Data Security</h2>
                <p class="text-slate-600 leading-relaxed mb-3">
                    We implement industry-standard security measures to protect your data, including:
                </p>
                <ul class="list-disc pl-6 space-y-2 text-slate-600">
                    <li>Encryption of data in transit using HTTPS/TLS</li>
                    <li>Secure storage of sensitive information</li>
                    <li>OTP-based authentication to prevent unauthorized access</li>
                    <li>Regular security audits and updates</li>
                    <li>Limited access controls for our team members</li>
                </ul>
                <p class="text-slate-600 leading-relaxed mt-4">
                    While we strive to protect your data, no method of transmission over the internet is 100% secure. 
                    We cannot guarantee absolute security but continuously work to improve our safeguards.
                </p>
            </section>

            <section class="mb-10">
                <h2 class="text-2xl font-bold mb-3">Data Retention</h2>
                <p class="text-slate-600 leading-relaxed">
                    We retain your personal data for as long as your account is active or as needed to provide you services. 
                    If you delete your account, we will remove or anonymize your data within a reasonable timeframe, 
                    except where we are required to retain it for legal, accounting, or security purposes.
                </p>
            </section>

            <section class="mb-10">
                <h2 class="text-2xl font-bold mb-3">Your Rights</h2>
                <p class="text-slate-600 leading-relaxed mb-3">You have the right to:</p>
                <ul class="list-disc pl-6 space-y-2 text-slate-600">
                    <li><strong>Access:</strong> Request a copy of the personal data we hold about you</li>
                    <li><strong>Correction:</strong> Update or correct inaccurate information in your profile</li>
                    <li><strong>Deletion:</strong> Request deletion of your account and associated data</li>
                    <li><strong>Portability:</strong> Request your data in a structured, machine-readable format</li>
                    <li><strong>Withdraw Consent:</strong> Opt out of non-essential data processing</li>
                    <li><strong>Object:</strong> Object to processing of your data for certain purposes</li>
                </ul>
                <p class="text-slate-600 leading-relaxed mt-4">
                    To exercise any of these rights, please contact us using the information provided below.
                </p>
            </section>

            <section class="mb-10">
                <h2 class="text-2xl font-bold mb-3">Children's Privacy</h2>
                <p class="text-slate-600 leading-relaxed">
                    Fendo is not intended for users under the age of 13 (or the applicable age of digital consent in your jurisdiction). 
                    We do not knowingly collect personal data from children. If you believe we have collected data from a child, 
                    please contact us immediately so we can delete it.
                </p>
            </section>

            <section class="mb-10">
                <h2 class="text-2xl font-bold mb-3">International Data Transfers</h2>
                <p class="text-slate-600 leading-relaxed">
                    Your data may be stored and processed in countries outside your own. 
                    When we transfer data internationally, we ensure appropriate safeguards are in place to protect your information 
                    in accordance with applicable data protection laws.
                </p>
            </section>

            <section class="mb-10">
                <h2 class="text-2xl font-bold mb-3">Cookies and Tracking</h2>
                <p class="text-slate-600 leading-relaxed">
                    Our mobile app does not use cookies. Our website may use basic analytics to understand visitor behavior. 
                    We do not use tracking technologies for advertising purposes.
                </p>
            </section>

            <section class="mb-10">
                <h2 class="text-2xl font-bold mb-3">Changes to This Policy</h2>
                <p class="text-slate-600 leading-relaxed">
                    We may update this privacy policy from time to time to reflect changes in our practices or legal requirements. 
                    We will notify you of significant changes through the app or via email. 
                    Your continued use of Fendo after changes are posted constitutes acceptance of the updated policy.
                </p>
            </section>

            <section class="mb-10">
                <h2 class="text-2xl font-bold mb-3">Contact Us</h2>
                <p class="text-slate-600 leading-relaxed mb-4">
                    If you have questions, concerns, or requests regarding this privacy policy or your personal data, please contact us:
                </p>
                <div class="bg-slate-50 rounded-xl p-6 border border-slate-200">
                    <p class="text-slate-700 mb-2"><strong>Fendo Support</strong></p>
                    <p class="text-slate-600">Email: <a href="mailto:fendo@posquickcart.com" class="text-fendo hover:underline">fendo@posquickcart.com</a></p>
                    <p class="text-slate-600 mt-4 text-sm">
                        We will respond to your inquiry within a reasonable timeframe, typically within 30 days.
                    </p>
                </div>
            </section>

            <section class="pt-8 border-t border-slate-200">
                <p class="text-slate-500 text-sm">
                    By using Fendo, you acknowledge that you have read and understood this privacy policy 
                    and agree to the collection, use, and disclosure of your information as described herein.
                </p>
            </section>
        </div>
    </div>

    <footer class="border-t border-slate-100 mt-12">
        <div class="max-w-6xl mx-auto px-6 py-8 flex flex-col sm:flex-row items-center justify-between gap-3 text-sm text-slate-500">
            <span class="font-semibold text-slate-700">fendo</span>
            <div class="flex gap-6">
                <a href="/privacy" class="hover:text-fendo">Privacy Policy</a>
                <a href="/" class="hover:text-fendo">Home</a>
            </div>
        </div>
    </footer>
</body>
</html>
