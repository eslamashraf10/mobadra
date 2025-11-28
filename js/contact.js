// Contact form handling
document.getElementById('contactForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const department = document.getElementById('dept').value;
    const message = document.getElementById('message').value;
    
    // Create message object
    const contactMessage = {
        id: Date.now(),
        name: name,
        email: email,
        department: department,
        message: message,
        date: new Date().toISOString()
    };
    
    // Save message to localStorage
    let messages =  [];
    messages.push(contactMessage);
    
    // Send to backend (mock)
    sendToBackend(contactMessage);
    
    // Reset form
    document.getElementById('contactForm').reset();
    
    // Show success message
    alert('Your message has been sent successfully!');
});

// Send to backend
function sendToBackend(message) {
    // Mock sending to backend
    // In a real application, this would be an API call
    console.log('Sending message to backend:', message);
    
    // You can add code to send data to a real API here
    // fetch('/api/contact', {
    //     method: 'POST',
    //     headers: { 'Content-Type': 'application/json' },
    //     body: JSON.stringify(message)
    // });
}
