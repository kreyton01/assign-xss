# assign-xss

## register.php Changes:

### Added CSRF token generation and validation: The CSRF token is a security measure implemented to protect against malicious attacks. It is generated on the server-side and associated with the user's session. The token is included in the registration form and validated when the form is submitted to ensure the request is legitimate.
### Implemented anti-XSS measures: To prevent harmful scripts from being injected, user input on the registration form is sanitized.

## index.php Changes:

### Updated form to include CSRF token: The login form was modified to include the CSRF token as a hidden field. This token is sent with the form data to verify the authenticity of the login request.

### Applied anti-XSS measures: Similar to the registration form, user input on the login form is sanitized and escaped to prevent cross-site scripting attacks.

## login.php Changes:

### Added CSRF token validation: CSRF token validation was implemented during the login process to ensure that the request is genuine and not a malicious attack. The submitted token is compared to the one stored in the user's session.

### No explicit anti-XSS measures: Since the login process involves minimal user-generated content, the risk of cross-site scripting attacks is low. 