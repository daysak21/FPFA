import mysql.connector
import math
import random

class ProductRecommender:
    def __init__(self, db_config):
        """Initialise le système de recommandation avec la configuration de la base de données"""
        self.db_config = db_config
        self.conn = None
        self.cursor = None
        
    def connect_db(self):
        """Établit une connexion à la base de données"""
        try:
            self.conn = mysql.connector.connect(**self.db_config)
            self.cursor = self.conn.cursor(dictionary=True)
            return True
        except Exception as e:
            print(f"Erreur de connexion à la base de données: {e}")
            return False
            
    def close_db(self):
        """Ferme la connexion à la base de données"""
        if self.cursor:
            self.cursor.close()
        if self.conn:
            self.conn.close()
    
    def get_product_details(self, product_id):
        """Récupère les détails d'un produit spécifique"""
        query = """
        SELECT product_id, product_title, category_id, brand_id, product_price 
        FROM products 
        WHERE product_id = %s
        """
        self.cursor.execute(query, (product_id,))
        return self.cursor.fetchone()
    
    def get_all_products(self):
        """Récupère tous les produits de la base de données"""
        query = """
        SELECT product_id, product_title, category_id, brand_id, product_price 
        FROM products 
        WHERE status = 'true'
        """
        self.cursor.execute(query)
        return self.cursor.fetchall()
    
    def calculate_similarity_score(self, product1, product2):
        """Calcule un score de similarité entre deux produits"""
        # Facteurs de pondération pour différentes caractéristiques
        category_weight = 0.4
        brand_weight = 0.3
        price_weight = 0.3
        
        # Score initial
        score = 0
        
        # Même catégorie
        if product1['category_id'] == product2['category_id']:
            score += category_weight
        
        # Même marque
        if product1['brand_id'] == product2['brand_id']:
            score += brand_weight
        
        # Proximité de prix (normalisée)
        price_diff = abs(product1['product_price'] - product2['product_price'])
        max_price = max(product1['product_price'], product2['product_price'])
        price_similarity = 1 - (price_diff / max_price if max_price > 0 else 0)
        score += price_weight * price_similarity
        
        return score
    
    def minmax_recommendation(self, product_id, depth=3, alpha=-float('inf'), beta=float('inf')):
        """
        Utilise l'algorithme MinMax avec élagage Alpha-Beta pour trouver les produits recommandés
        
        Args:
            product_id: ID du produit pour lequel on cherche des recommandations
            depth: Profondeur de recherche dans l'arbre de décision
            alpha, beta: Paramètres pour l'élagage Alpha-Beta
            
        Returns:
            Liste des IDs de produits recommandés avec leurs scores
        """
        if not self.connect_db():
            return []
        
        try:
            # Récupérer le produit cible
            target_product = self.get_product_details(product_id)
            if not target_product:
                return []
            
            # Récupérer tous les produits
            all_products = self.get_all_products()
            
            # Filtrer pour exclure le produit cible
            candidate_products = [p for p in all_products if p['product_id'] != product_id]
            
            # Calculer les scores de similarité pour chaque produit
            product_scores = []
            
            for product in candidate_products:
                # Appliquer l'algorithme MinMax avec élagage Alpha-Beta
                score = self._minmax(target_product, product, depth, True, alpha, beta)
                product_scores.append((product['product_id'], score))
            
            # Trier par score décroissant
            product_scores.sort(key=lambda x: x[1], reverse=True)
            
            return product_scores
        
        finally:
            self.close_db()
    
    def _minmax(self, target_product, candidate_product, depth, is_maximizing, alpha, beta):
        """
        Implémentation récursive de l'algorithme MinMax avec élagage Alpha-Beta
        
        Args:
            target_product: Produit cible
            candidate_product: Produit candidat à évaluer
            depth: Profondeur restante dans l'arbre
            is_maximizing: Indique si on maximise ou minimise le score
            alpha, beta: Paramètres pour l'élagage Alpha-Beta
            
        Returns:
            Score optimal pour ce nœud
        """
        # Cas de base: profondeur atteinte ou nœud terminal
        if depth == 0:
            return self.calculate_similarity_score(target_product, candidate_product)
        
        # Caractéristiques à considérer pour les nœuds enfants
        features = ['category_id', 'brand_id', 'product_price']
        
        if is_maximizing:
            max_eval = -float('inf')
            for feature in features:
                # Simuler un "mouvement" en modifiant légèrement la caractéristique
                original_value = candidate_product[feature]
                
                # Pour les IDs, on simule un changement de catégorie/marque
                if feature in ['category_id', 'brand_id']:
                    # Simuler un changement vers la même catégorie/marque que le produit cible
                    candidate_product[feature] = target_product[feature]
                else:  # Pour le prix
                    # Ajuster le prix pour se rapprocher du produit cible
                    candidate_product[feature] = (candidate_product[feature] + target_product[feature]) / 2
                
                # Évaluation récursive
                eval_score = self._minmax(target_product, candidate_product, depth - 1, False, alpha, beta)
                max_eval = max(max_eval, eval_score)
                
                # Restaurer la valeur originale
                candidate_product[feature] = original_value
                
                # Élagage Alpha-Beta
                alpha = max(alpha, eval_score)
                if beta <= alpha:
                    break  # Coupure Beta
                
            return max_eval
        
        else:  # Minimizing player
            min_eval = float('inf')
            for feature in features:
                # Simuler un "mouvement" en modifiant légèrement la caractéristique
                original_value = candidate_product[feature]
                
                # Pour les IDs, on simule un changement de catégorie/marque
                if feature in ['category_id', 'brand_id']:
                    # Simuler un changement vers une catégorie/marque différente
                    candidate_product[feature] = random.randint(1, 10)  # Valeur aléatoire
                else:  # Pour le prix
                    # Ajuster le prix pour s'éloigner du produit cible
                    price_diff = abs(candidate_product[feature] - target_product[feature])
                    candidate_product[feature] = candidate_product[feature] + price_diff * 0.2
                
                # Évaluation récursive
                eval_score = self._minmax(target_product, candidate_product, depth - 1, True, alpha, beta)
                min_eval = min(min_eval, eval_score)
                
                # Restaurer la valeur originale
                candidate_product[feature] = original_value
                
                # Élagage Alpha-Beta
                beta = min(beta, eval_score)
                if beta <= alpha:
                    break  # Coupure Alpha
                
            return min_eval
    
    def get_recommended_products(self, product_id, num_recommendations=3):
        """
        Obtient les produits recommandés pour un produit donné
        
        Args:
            product_id: ID du produit pour lequel on cherche des recommandations
            num_recommendations: Nombre de recommandations à retourner
            
        Returns:
            Liste des IDs de produits recommandés
        """
        recommendations = self.minmax_recommendation(product_id)
        
        # Retourner les N meilleurs produits recommandés
        top_recommendations = recommendations[:num_recommendations]
        return [product_id for product_id, score in top_recommendations]

# Exemple d'utilisation
if __name__ == "__main__":
    # Configuration de la base de données
    db_config = {
        'host': 'localhost',
        'user': 'root',
        'password': '',
        'database': 'fpfaa'
    }
    
    # Créer une instance du recommandeur
    recommender = ProductRecommender(db_config)
    
    # Obtenir des recommandations pour le produit avec ID 1
    product_id = 1
    recommendations = recommender.get_recommended_products(product_id, 3)
    
    print(f"Produits recommandés pour le produit {product_id}:")
    for rec_id in recommendations:
        print(f"- Produit ID: {rec_id}")