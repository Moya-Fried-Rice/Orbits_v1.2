<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sentiment Analysis Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6">Sentiment Analysis Test</h1>

        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-2">Test Direct API Call</h2>
            <form id="testForm" class="space-y-4">
                <div>
                    <label class="block text-gray-700 mb-1">Enter text to analyze:</label>
                    <textarea id="testText" class="w-full border rounded p-2" rows="3">The professor is very knowledgeable and helpful.</textarea>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Analyze</button>
            </form>
        </div>

        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-2">Results</h2>
            <div id="results" class="border rounded p-4 bg-gray-50 min-h-20">
                <p class="text-gray-500">Results will appear here...</p>
            </div>
        </div>

        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-2">API Response</h2>
            <pre id="apiResponse" class="border rounded p-4 bg-gray-50 overflow-auto max-h-60 text-xs"></pre>
        </div>
    </div>

    <script>
        document.getElementById('testForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const text = document.getElementById('testText').value;
            const resultsDiv = document.getElementById('results');
            const responseDiv = document.getElementById('apiResponse');
            
            resultsDiv.innerHTML = '<p class="text-gray-500">Analyzing...</p>';
            responseDiv.textContent = '';
            
            fetch('http://127.0.0.1:5003/analyze_sentiment', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ text })
            })
            .then(response => response.json())
            .then(data => {
                // Display formatted result
                let sentiment = data.sentiment || 'unknown';
                let comment = data.comment || 'No comment available';
                
                let sentimentClass = 'text-gray-800';
                if (sentiment === 'positive') sentimentClass = 'text-green-600';
                else if (sentiment === 'negative') sentimentClass = 'text-red-600';
                else if (sentiment === 'neutral') sentimentClass = 'text-blue-600';
                
                resultsDiv.innerHTML = `
                    <div class="mb-3">
                        <strong>Text:</strong> <span class="text-gray-700">${data.text || text}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Sentiment:</strong> <span class="${sentimentClass} font-semibold">${sentiment.toUpperCase()}</span>
                    </div>
                    <div>
                        <strong>Comment:</strong> <span class="text-gray-700">${comment}</span>
                    </div>
                `;
                
                // Display raw API response
                responseDiv.textContent = JSON.stringify(data, null, 2);
            })
            .catch(error => {
                resultsDiv.innerHTML = `<p class="text-red-500">Error: ${error.message}</p>`;
                console.error('Error:', error);
            });
        });
    </script>
</body>
</html>
