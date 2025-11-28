// Simple Backend file containing two static messages
// This is a mock backend file - in a real application this would be on the server

const staticMessages = [
    {
        id: 1,
        name: 'Ahmed Mohamed',
        email: 'ahmed.mohamed@company.com',
        department: 'IT',
        message: 'I need help updating the company management system. Can you provide technical support?',
        date: '2025-01-15T10:30:00Z'
    },
    {
        id: 2,
        name: 'Sara Ali',
        email: 'sara.ali@company.com',
        department: 'HR',
        message: 'I would like to know more about the company\'s new policies and hiring procedures.',
        date: '2025-01-16T14:20:00Z'
    }
];

// Function to get static messages
function getStaticMessages() {
    return staticMessages;
}

// Function to add a new message
function addMessage(message) {
    const newMessage = {
        id: Date.now(),
        ...message,
        date: new Date().toISOString()
    };
    staticMessages.push(newMessage);
    return newMessage;
}


