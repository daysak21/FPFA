from flask import Flask, request, jsonify
import mysql.connector
import math
import random
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity

app = Flask(__name__)

class ProductRecommender:
    def __init__(self, db_config):
        self.db_config = db_config
        self.conn = None
        self.cursor = None

    def connect_db(self):
        try:
            self.conn = mysql.connector.connect(**self.db_config)
            self.cursor = self.conn.cursor(dictionary=True)
            return True
        except Exception as e:
            print(f"Erreur DB: {e}")
            return False

    def close_db(self):
        if self.cursor:
            self.cursor.close()
        if self.conn:
            self.conn.close()

    def get_product_details(self, product_id):
        self.cursor.execute("""
            SELECT product_id, product_title, description, category_id, brand_id, product_price 
            FROM products WHERE product_id = %s
        """, (product_id,))
        return self.cursor.fetchone()

    def get_all_products(self):
        self.cursor.execute("""
            SELECT product_id, product_title, description, category_id, brand_id, product_price 
            FROM products WHERE status = 'true'
        """)
        return self.cursor.fetchall()

    def calculate_similarity_score(self, p1, p2):
        score = 0
        score += 0.4 if p1['category_id'] == p2['category_id'] else 0
        score += 0.3 if p1['brand_id'] == p2['brand_id'] else 0
        price_diff = abs(p1['product_price'] - p2['product_price'])
        max_price = max(p1['product_price'], p2['product_price'])
        price_similarity = 1 - (price_diff / max_price if max_price > 0 else 0)
        score += 0.3 * price_similarity

        description_similarity = self.calculate_description_similarity(p1['description'], p2['description'])
        score += 0.2 * description_similarity 
        return score

    def calculate_description_similarity(self, description1, description2):

        vectorizer = TfidfVectorizer(stop_words='english')
        tfidf_matrix = vectorizer.fit_transform([description1, description2])
        

        similarity_matrix = cosine_similarity(tfidf_matrix[0:1], tfidf_matrix[1:2])
        return similarity_matrix[0][0]

    def _minmax(self, p1, p2, depth, is_max, alpha, beta):
        if depth == 0:
            return self.calculate_similarity_score(p1, p2)
        features = ['category_id', 'brand_id', 'product_price']
        if is_max:
            max_eval = -float('inf')
            for f in features:
                original = p2[f]
                p2[f] = p1[f] if f != 'product_price' else (p2[f] + p1[f]) / 2
                eval_score = self._minmax(p1, p2, depth - 1, False, alpha, beta)
                p2[f] = original
                max_eval = max(max_eval, eval_score)
                alpha = max(alpha, eval_score)
                if beta <= alpha:
                    break
            return max_eval
        else:
            min_eval = float('inf')
            for f in features:
                original = p2[f]
                if f != 'product_price':
                    p2[f] = random.randint(1, 10)
                else:
                    diff = abs(p2[f] - p1[f])
                    p2[f] += diff * 0.2
                eval_score = self._minmax(p1, p2, depth - 1, True, alpha, beta)
                p2[f] = original
                min_eval = min(min_eval, eval_score)
                beta = min(beta, eval_score)
                if beta <= alpha:
                    break
            return min_eval

    def get_recommendations(self, product_id, count):
        if not self.connect_db():
            return []
        try:
            target = self.get_product_details(product_id)
            if not target:
                return []
            products = [p for p in self.get_all_products() if p['product_id'] != product_id]
            scored = []
            for p in products:
                score = self._minmax(target, p, 3, True, -float('inf'), float('inf'))
                scored.append((p['product_id'], score))
            scored.sort(key=lambda x: x[1], reverse=True)
            return [p[0] for p in scored[:count]]
        finally:
            self.close_db()


db_config = {
    'host': 'localhost',
    'user': 'root',
    'password': '',
    'database': 'fpfaa'
}
recommender = ProductRecommender(db_config)


@app.route("/api/recommend", methods=["GET"])
def recommend():
    product_id = request.args.get("product_id", type=int)
    count = request.args.get("count", default=3, type=int)

    if not product_id:
        return jsonify({"error": "Missing product_id"}), 400

    recommendations = recommender.get_recommendations(product_id, count)
    return jsonify({"product_id": product_id, "recommendations": recommendations})


if __name__ == "__main__":
    app.run(host="127.0.0.1", port=80, debug=True) 
