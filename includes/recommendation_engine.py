from flask import Flask, request, jsonify
import mysql.connector
from mysql.connector import Error
import re
from flask_cors import CORS
import nltk
from nltk.stem import WordNetLemmatizer
from nltk.corpus import stopwords
import string

app = Flask(__name__)
CORS(app)


# Initialize lemmatizer
lemmatizer = WordNetLemmatizer()

# Database configuration - Updated to match your PHP connection
db_config = {
    'host': 'localhost',  # Changed from '127.0.0.1' to match PHP
    'database': 'fpfaa',
    'user': 'root',       # Changed from 'your_username' to match PHP
    'password': ''        # Changed from 'your_password' to empty string to match PHP
}

def get_db_connection():
    try:
        connection = mysql.connector.connect(**db_config)
        return connection
    except Error as e:
        print(f"Error connecting to MySQL: {e}")
        return None

def extract_keywords(message):
    """Extract potential product keywords from user message"""
    keywords = []
    message = message.lower()
    
    # Common product categories in your database
    categories = [
        'watch', 'iphone', 'smartphone', 'laptop', 'camera', 'gamer', 'pc', 
        'tablet', 'headphone', 'earbuds', 'monitor', 'keyboard', 'mouse',
        # French translations
        'montre', 'téléphone', 'ordinateur', 'appareil', 'tablette', 'écouteurs',
        'écran', 'clavier', 'souris', 'phone', 'mobile'
    ]
    
    # Check for brand names
    brands = [
        'apple', 'samsung', 'msi', 'dell', 'asus', 'hp', 'canon', 'sony',
        'lenovo', 'acer', 'lg', 'huawei', 'xiaomi', 'oppo', 'vivo', 'oneplus'
    ]
    
    # Check for price mentions
    price_ranges = re.findall(r'\$?\d+-\$?\d+|\$?\d+\+?', message.lower())
    
    # Check for specific product features
    features = [
        'gps', 'camera', 'ssd', 'ram', 'display', 'touchscreen', 'wireless',
        'bluetooth', 'gaming', 'professional', 'lightweight', 'portable'
    ]
    
    # Add matches to keywords
    for word in message.lower().split():
        if word in categories:
            keywords.append(word)
        if word in brands:
            keywords.append(word)
        if word in features:
            keywords.append(word)
    
    keywords.extend(price_ranges)
    
    # Check for common phrases
    if 'want a phone' in message or 'need a phone' in message or 'looking for a phone' in message:
        keywords.append('smartphone')
        keywords.append('phone')
    
    if 'want a laptop' in message or 'need a laptop' in message or 'looking for a laptop' in message:
        keywords.append('laptop')
    
    # French phrases
    if 'veux un téléphone' in message or 'besoin d\'un téléphone' in message or 'cherche un téléphone' in message:
        keywords.append('smartphone')
        keywords.append('phone')
    
    return list(set(keywords))  # Remove duplicates

def get_recommendations(keywords):
    """Get product recommendations based on extracted keywords"""
    if not keywords:
        return None
    
    connection = get_db_connection()
    if not connection:
        return None
    
    try:
        cursor = connection.cursor(dictionary=True)
        
        # Build query based on keywords
        query = """
        SELECT product_id, product_title, product_price, product_image_one 
        FROM products 
        WHERE status = 'true' AND (
        """
        
        conditions = []
        params = []
        
        for keyword in keywords:
            if '-' in keyword and keyword.replace('-', '').replace('DT', '').isdigit():
                # Handle price range (e.g., "100-200")
                low, high = map(lambda x: int(x.replace('DT', '')), keyword.split('-'))
                conditions.append("(product_price BETWEEN %s AND %s)")
                params.extend([low, high])
            elif keyword.endswith('+') and keyword[:-1].replace('DT', '').isdigit():
                # Handle minimum price (e.g., "500+")
                min_price = int(keyword[:-1].replace('DT', ''))
                conditions.append("(product_price >= %s)")
                params.append(min_price)
            else:
                # Handle regular keywords
                conditions.append("""
                (product_title LIKE %s OR 
                 product_description LIKE %s OR 
                 product_keywords LIKE %s)
                """)
                params.extend([f'%{keyword}%', f'%{keyword}%', f'%{keyword}%'])
        
        query += " OR ".join(conditions)
        query += ") ORDER BY product_price ASC LIMIT 5"
        
        cursor.execute(query, params)
        results = cursor.fetchall()
        
        return results if results else None
        
    except Error as e:
        print(f"Error executing query: {e}")
        return None
    finally:
        if connection.is_connected():
            cursor.close()
            connection.close()

@app.route('/recommend', methods=['POST'])
def recommend():
    data = request.get_json()
    message = data.get('message', '')
    
    keywords = extract_keywords(message)
    print(f"Extracted keywords: {keywords}")  # Debug log
    
    recommendations = get_recommendations(keywords)
    
    if recommendations:
        formatted_recs = []
        for product in recommendations:
            formatted_recs.append({
                'title': product['product_title'],
                'price': product['product_price'],
                'image': product['product_image_one'],
                'id': product['product_id']
            })
        
        return jsonify({
            'status': 'success',
            'recommendations': formatted_recs,
            'keywords': keywords  # Return keywords for debugging
        })
    else:
        return jsonify({
            'status': 'no_results',
            'message': 'No products found matching your criteria.',
            'keywords': keywords  # Return keywords for debugging
        })

if __name__ == '__main__':
    app.run(debug=True)
