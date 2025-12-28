<!DOCTYPE html>
<html>
<head>
    <title>Invitation</title>
    <style>
        /* Basic inline styles for better email client compatibility */
        body { font-family: sans-serif; }
        .button { background-color: #007BFF; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center">
                <table width="600" cellpadding="20" cellspacing="0" border="0" style="border: 1px solid #ddd;">
                    <tr>
                        <td align="center" style="background-color: #f4f4f4;">
                            <img src="your-logo.png" alt="Your Brand Logo" width="150">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h1>You're Invited to {{ config('app.name') }}!</h1>
                            <p>Hi {{ $user['name'] }},</p>
                            <p>Click the button below to get started:</p>
                            <p><a href="{{ $url }}" class="button">Accept Invitation</a></p>
                            <p>Thanks,<br>The {{ $user['company']['title'] }} Team</p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="font-size: 12px; color: #888;">
                            &copy; 2025 {{ config('app.name') }}. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
