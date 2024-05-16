const http = require('http');
const fs = require('fs');
const path = require('path');

const server = http.createServer((req, res) => {
    let filePath;

    // Determine the file path based on the requested URL
    if (req.url === '/main.html') {
        filePath = path.join(__dirname, 'main.html');
    } else if (req.url === '/login.css') {
        filePath = path.join(__dirname, 'login.css');
    } else {
        // Return a 404 error if the requested file is not found
        res.writeHead(404, { 'Content-Type': 'text/plain' });
        res.end('File not found');
        return;
    }

    // Read the requested file
    fs.readFile(filePath, (err, data) => {
        if (err) {
            res.writeHead(500, { 'Content-Type': 'text/plain' });
            res.end('Internal Server Error');
        } else {
            // Determine the content type based on the file extension
            const ext = path.extname(filePath);
            let contentType = 'text/html';
            if (ext === '.css') {
                contentType = 'text/css';
            }

            // Serve the file with the appropriate content type
            res.writeHead(200, { 'Content-Type': contentType });
            res.end(data);
        }
    });
});

const PORT = process.env.PORT || 3000;
server.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
});
