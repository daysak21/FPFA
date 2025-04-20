from flask import Flask, request, jsonify

app = Flask(__name__)

# Simuler des produits recommandés
def recommend_products(user_message):
    # Logic for recommendations goes here (e.g., filtering or collaborative filtering)
    # Exemple de recommandation basée sur le mot-clé
    if "phone" in user_message.lower():
        return ["Phone A", "Phone B", "Phone C"]
    elif "laptop" in user_message.lower():
        return ["Laptop A", "Laptop B", "Laptop C"]
    else:
        return []

@app.route('/recommend', methods=['POST'])
def recommend():
    data = request.json
    user_message = data.get('message', '')
    
    # Obtenir des recommandations basées sur le message utilisateur
    recommended_products = recommend_products(user_message)
    
    return jsonify({'recommended_products': recommended_products})

if __name__ == '__main__':
    app.run(debug=True)
