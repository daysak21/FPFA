from flask import Flask, request, jsonify
from flask_cors import CORS
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity
import nltk
from nltk.corpus import stopwords
from nltk.tokenize import word_tokenize
from nltk.stem import PorterStemmer
import mysql.connector
import os
import sys
import traceback

app = Flask(__name__)
CORS(app)  # Enable CORS for all routes

# Download NLTK resources (uncomment if not already downloaded)
try:
    nltk.data.find('tokenizers/punkt')
    nltk.data.find('corpora/stopwords')
except LookupError:
    nltk.download('punkt')
    nltk.download('stopwords')

# Database connection
def get_db_connection():
    try:
        return mysql.connector.connect(
            host=os.getenv('DB_HOST', 'localhost'),
            user=os.getenv('DB_USER', 'root'),
            password=os.getenv('DB_PASSWORD', ''),
            database=os.getenv('DB_NAME', 'affar_db')  # Change to your database name
        )
    except mysql.connector.Error as err:
        print(f"Database connection error: {err}")
        return None

# Simple test data in case database is not available
test_products = [
    {
        "product_id": "1",
        "product_title": "Smartphone XYZ",
        "product_description": "A great smartphone with amazing features",
        "product_keywords": "phone, smartphone, mobile, electronics",
        "product_price": 499.99,
        "product_image1": "smartphone.jpg"
    },
    {
        "product_id": "2",
        "product_title": "Laptop ABC",
        "product_description": "Powerful laptop for work and gaming",
        "product_keywords": "laptop, computer, notebook, electronics",
        "product_price": 899.99,
        "product_image1": "laptop.jpg"
    },
    {
        "product_id": "3",
        "product_title": "Headphones Pro",
        "product_description": "Premium noise-cancelling headphones",
        "product_keywords": "headphones, audio, music, electronics",
        "product_price": 199.99,
        "product_image1": "headphones.jpg"
    }
]

# Preprocessing function
def preprocess_text(text):
    if not text:
        return ""
    try:
        stop_words = set(stopwords.words('english'))
        stemmer = PorterStemmer()

        # Tokenize, lowercase, remove stopwords, and apply stemming
        tokens = word_tokenize(str(text).lower())
        filtered_tokens = [stemmer.stem(word) for word in tokens if word.isalpha() and word not in stop_words]
        
        return " ".join(filtered_tokens)
    except Exception as e:
        print(f"Error in preprocess_text: {e}")
        return ""

# Get all products from database
def get_all_products():
    try:
        conn = get_db_connection()
        if not conn:
            print("Using test products because database connection failed")
            return test_products
            
        cursor = conn.cursor(dictionary=True)
        
        cursor.execute("SELECT product_id, product_title, product_description, product_keywords, product_price, product_image1 FROM products")
        products = cursor.fetchall()
        
        cursor.close()
        conn.close()
        
        if not products:
            print("No products found in database, using test products")
            return test_products
            
        return products
    except Exception as e:
        print(f"Database error in get_all_products: {e}")
        print(traceback.format_exc())
        return test_products

@app.route('/search', methods=['GET'])
def search():
    query = request.args.get('q', '')
    
    if not query or len(query) < 2:
        return jsonify([])
    
    try:
        # Get all products
        products = get_all_products()
        
        if not products:
            return jsonify([])
        
        # Create document dictionary for TF-IDF
        documents = {}
        product_map = {}
        
        for product in products:
            # Combine title, description and keywords for better search
            doc_text = f"{product['product_title']} {product.get('product_description', '')} {product.get('product_keywords', '')}"
            doc_id = f"doc_{product['product_id']}"
            documents[doc_id] = doc_text
            product_map[doc_id] = product['product_id']
        
        # Preprocess documents and query
        processed_docs = {k: preprocess_text(v) for k, v in documents.items()}
        processed_query = preprocess_text(query)
        
        if not processed_query:
            return jsonify([])
            
        # Vectorization and similarity calculation
        vectorizer = TfidfVectorizer()
        tfidf_matrix = vectorizer.fit_transform(processed_docs.values())
        query_vector = vectorizer.transform([processed_query])
        similarity = cosine_similarity(query_vector, tfidf_matrix).flatten()
        
        # Ranking the documents
        ranked_indices = similarity.argsort()[::-1]
        ranked_docs = [(list(documents.keys())[i], similarity[i]) for i in ranked_indices if similarity[i] > 0.01]
        
        # Get top results
        top_results = ranked_docs[:8]
        
        # For test data, just return the products directly
        if products == test_products:
    # Apply filtering on test data too
            results = []
            for product in test_products:
                combined_text = f"{product['product_title']} {product.get('product_description', '')} {product.get('product_keywords', '')}"
                processed_text = preprocess_text(combined_text)
                score = cosine_similarity(vectorizer.transform([processed_query]), vectorizer.transform([processed_text]))[0][0]
                if score > 0.01:
                    product_copy = dict(product)
                    product_copy['score'] = float(score)
                    results.append(product_copy)
            return jsonify(sorted(results, key=lambda x: x['score'], reverse=True))


        
        # Get full product details for top results
        results = []
        for doc_id, score in top_results:
            product_id = product_map[doc_id]
            # Find the product in our list
            for product in products:
                if str(product['product_id']) == str(product_id):
                    product_copy = dict(product)
                    product_copy['score'] = float(score)
                    results.append(product_copy)
                    break
        
        return jsonify(results)
    
    except Exception as e:
        print(f"Error in search endpoint: {e}")
        print(traceback.format_exc())
        return jsonify({"error": str(e)}), 500

# Simple endpoint to test if the API is running
@app.route('/', methods=['GET'])
def home():
    return jsonify({"status": "API is running"})

if __name__ == '__main__':
    print("Starting search API on http://localhost:5000")
    app.run(debug=True, port=5000, host='0.0.0.0')
