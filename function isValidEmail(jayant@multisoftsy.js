function isValidEmail(jayant@multisoftsystems.com) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Example usage:
console.log(isValidEmail("test@example.com")); // true
console.log(isValidEmail("invalid-email")); // false