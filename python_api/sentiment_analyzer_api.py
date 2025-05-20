from flask import Flask, request, jsonify
import re
import joblib 
import os

app = Flask(__name__)

# --- Load your actual model and vectorizer ---
base_dir = os.path.dirname(os.path.abspath(__file__))
model_path = os.path.join(base_dir, 'sentiment_model.pkl') #Change 'sentiment_model.pkl' if your filename is different
vectorizer_path = os.path.join(base_dir, 'tfidf_vectorizer.pkl') #'vectorizer.pkl' if your filename is different

try:
    model = joblib.load(model_path)
    vectorizer = joblib.load(vectorizer_path)
    app.logger.info("Sentiment model and vectorizer loaded successfully.")
    app.logger.info(f"Model path: {model_path}")
    app.logger.info(f"Vectorizer path: {vectorizer_path}")
except FileNotFoundError:
    app.logger.error(f"Error: One or both .pkl files not found. Searched at:")
    app.logger.error(f"Model: {model_path}")
    app.logger.error(f"Vectorizer: {vectorizer_path}")
    app.logger.error("Please ensure the .pkl files are in the correct location and filenames are correct in the script.")
    model = None
    vectorizer = None
except Exception as e:
    app.logger.error(f"Error loading model/vectorizer: {e}")
    model = None
    vectorizer = None
# --- End Model Loading ---

def predict_sentiment_placeholder(text):
    """
    Placeholder sentiment prediction logic.
    Replace this with your actual model prediction using the loaded model and vectorizer.
    This version uses simple keyword matching for demonstration.
    """
    if not text or not isinstance(text, str):
        return "neutral" # Or handle as an error

    text_lower = text.lower()
    
    # More comprehensive keyword lists might be needed for better accuracy
    positive_keywords = [
        "good", "great", "excellent", "positive", "happy", "love", "best", "wonderful",
        "nice", "awesome", "fantastic", "pleased", "satisfied", "impressed", "helpful", "effective", "knowledgeable"
    ]
    negative_keywords = [
        "bad", "terrible", "poor", "negative", "sad", "hate", "worst", "awful",
        "disappointed", "frustrated", "unhelpful", "confusing", "difficult", "boring", "unclear"
    ]

    positive_score = 0
    negative_score = 0

    # Simple word check (can be improved with regex for whole words, etc.)
    for word in positive_keywords:
        if re.search(r'\b' + re.escape(word) + r'\b', text_lower):
            positive_score += 1
    
    for word in negative_keywords:
        if re.search(r'\b' + re.escape(word) + r'\b', text_lower):
            negative_score += 1

    if positive_score > negative_score:
        return "positive"
    elif negative_score > positive_score:
        return "negative"
    else:
        return "neutral" # Default to neutral if scores are equal or no keywords found

@app.route('/analyze_sentiment', methods=['POST'])
def analyze():
    try:
        data = request.get_json()
        if not data or 'text' not in data:
            app.logger.warning("Request missing 'text' field.")
            return jsonify({"error": "Missing 'text' field in request body"}), 400

        text_to_analyze = data['text']
        
        sentiment = "neutral" # Default sentiment

        if model and vectorizer:
            try:
                # Vectorize the input text
                text_vectorized = vectorizer.transform([text_to_analyze])
                # Predict using the model
                prediction = model.predict(text_vectorized)[0] # Assuming model.predict returns an array with one item

                if prediction == 1: # Example: if your model outputs 1 for positive
                    sentiment = "positive"
                elif prediction == 0: # Example: if your model outputs 0 for negative
                    sentiment = "negative"
                else: # Fallback or if your model has a different scheme
                    sentiment = "neutral" 
                    app.logger.info(f"Model prediction was '{prediction}', mapped to '{sentiment}'. Adjust mapping if needed.")

            except Exception as e:
                app.logger.error(f"Error during model prediction: {str(e)}")
                app.logger.info("Falling back to placeholder sentiment due to prediction error.")
                sentiment = predict_sentiment_placeholder(text_to_analyze) # Fallback to placeholder on error
        else:
            app.logger.warning("Model/vectorizer not loaded or error during loading. Using placeholder sentiment.")
            sentiment = predict_sentiment_placeholder(text_to_analyze)
        
        app.logger.info(f"Analyzed text: '{text_to_analyze[:50]}...' -> Sentiment: {sentiment}")

        return jsonify({"sentiment": sentiment})

    except Exception as e:
        app.logger.error(f"Error in /analyze_sentiment endpoint: {str(e)}")
        return jsonify({"error": "An internal server error occurred"}), 500

if __name__ == '__main__':
    # Make sure to run on a host and port accessible by your Laravel app.
    # '0.0.0.0' makes it accessible on your local network.
    # For XAMPP, Laravel usually runs on localhost (127.0.0.1).
    app.run(host='127.0.0.1', port=5000, debug=True)
