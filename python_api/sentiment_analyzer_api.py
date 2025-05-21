from flask import Flask, request, jsonify
import re
import joblib 
import os
import logging
import sys

# Configure logging to display all messages to console
logging.basicConfig(level=logging.DEBUG, 
                   format='%(asctime)s - %(name)s - %(levelname)s - %(message)s',
                   handlers=[logging.StreamHandler(sys.stdout)])

app = Flask(__name__)

# --- Load your actual model and vectorizer ---
base_dir = os.path.dirname(os.path.abspath(__file__))
model_path = os.path.join(base_dir, 'sentiment_model.pkl') 
vectorizer_path = os.path.join(base_dir, 'tfidf_vectorizer.pkl') 

print(f"Looking for model at: {model_path}")
print(f"Looking for vectorizer at: {vectorizer_path}")
print(f"Do files exist? Model: {os.path.exists(model_path)}, Vectorizer: {os.path.exists(vectorizer_path)}")

try:
    print("Attempting to load model...")
    model = joblib.load(model_path)
    print("Model loaded successfully.")
    print("Attempting to load vectorizer...")
    vectorizer = joblib.load(vectorizer_path)
    print("Vectorizer loaded successfully.")
    app.logger.info("Sentiment model and vectorizer loaded successfully.")
except FileNotFoundError as e:
    print(f"FileNotFoundError: {str(e)}")
    app.logger.error(f"Error: One or both .pkl files not found. Searched at:")
    app.logger.error(f"Model: {model_path}")
    app.logger.error(f"Vectorizer: {vectorizer_path}")
    model = None
    vectorizer = None
except Exception as e:
    print(f"Error loading model/vectorizer: {str(e)}")
    app.logger.error(f"Error loading model/vectorizer: {str(e)}")
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
        comment = ""  # Initialize comment field

        if model and vectorizer:
            try:
                # Vectorize the input text
                text_vectorized = vectorizer.transform([text_to_analyze])
                # First check if the text contains obvious positive words
                text_lower = text_to_analyze.lower()
                obvious_positive = any(word in text_lower for word in ["good", "great", "excellent", "helpful", "knowledgeable"])
                obvious_negative = any(word in text_lower for word in ["bad", "terrible", "poor", "unhelpful", "boring"])
                
                # Predict using the model
                prediction = model.predict(text_vectorized)[0]
                app.logger.info(f"Raw model prediction: {prediction}")
                
                # Override prediction for short, simple phrases that should be clearly positive/negative
                if obvious_positive and not obvious_negative and len(text_to_analyze.split()) < 10:
                    prediction = 2  # Force positive for short, obviously positive comments
                elif obvious_negative and not obvious_positive and len(text_to_analyze.split()) < 10:
                    prediction = 0  # Force negative for short, obviously negative comments
                
                # Handle three-class model: usually 0=negative, 1=neutral, 2=positive
                # Adjust these mappings based on your actual model's output
                if prediction == 2:
                    sentiment = "positive"
                    comment = "The feedback is positive and shows satisfaction with the teaching experience."
                elif prediction == 0:
                    sentiment = "negative"
                    comment = "The feedback indicates areas of concern or dissatisfaction that may need addressing."
                elif prediction == 1:
                    sentiment = "neutral"
                    comment = "The feedback is factual or balanced without strong positive or negative sentiment."
                else:
                    app.logger.info(f"Model prediction was '{prediction}', mapped to '{sentiment}'. Adjust mapping if needed.")
                    comment = "The sentiment couldn't be clearly determined."

            except Exception as e:
                app.logger.error(f"Error during model prediction: {str(e)}")
                app.logger.info("Falling back to placeholder sentiment due to prediction error.")
                sentiment = predict_sentiment_placeholder(text_to_analyze) # Fallback to placeholder on error
                if sentiment == "positive":
                    comment = "Based on keyword analysis, the feedback appears positive."
                elif sentiment == "negative":
                    comment = "Based on keyword analysis, the feedback appears to contain concerns."
                else:
                    comment = "The feedback appears to be neutral or balanced."
        else:
            app.logger.warning("Model/vectorizer not loaded or error during loading. Using placeholder sentiment.")
            sentiment = predict_sentiment_placeholder(text_to_analyze)
            if sentiment == "positive":
                comment = "Based on keyword analysis, the feedback appears positive."
            elif sentiment == "negative":
                comment = "Based on keyword analysis, the feedback appears to contain concerns."
            else:
                comment = "The feedback appears to be neutral or balanced."
        
        app.logger.info(f"Analyzed text: '{text_to_analyze[:50]}...' -> Sentiment: {sentiment}, Comment: {comment}")

        # Return the original text along with sentiment and comment
        return jsonify({
            "text": text_to_analyze,
            "sentiment": sentiment, 
            "comment": comment
        })

    except Exception as e:
        app.logger.error(f"Error in /analyze_sentiment endpoint: {str(e)}")
        return jsonify({"error": "An internal server error occurred"}), 500

if __name__ == '__main__':
    # Make sure to run on a host and port accessible by your Laravel app.
    # '0.0.0.0' makes it accessible on your local network.
    # For XAMPP, Laravel usually runs on localhost (127.0.0.1).
    # Changed port from 5002 to 5003 to avoid conflicts
    app.run(host='127.0.0.1', port=5003, debug=True)
