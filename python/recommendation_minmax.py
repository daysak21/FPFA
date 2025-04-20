import mysql.connector
import pandas as pd
import numpy as np
from sklearn.preprocessing import MinMaxScaler
from sklearn.metrics.pairwise import cosine_similarity
import json
import os
from dotenv import load_dotenv

# Charger les variables d'environnement
load_dotenv()

# Configuration de la base de données
DB_HOST = os.getenv('DB_HOST', 'localhost')
DB_USER = os.getenv('DB_USER', 'root')
DB_PASSWORD = os.getenv('DB_PASSWORD', '')
DB_NAME = os.getenv('DB_NAME', 'fpfaa')

def get_db_connection():
    """Établir une connexion à la base de données"""
    try:
        conn = mysql.connector.connect(
            host=DB_HOST,
            user=DB_USER,
            password=DB_PASSWORD,
            database=DB_NAME
        )
        return conn
    except mysql.connector.Error as e:
        print(f"Erreur de connexion à la base de données: {e}")
        return None

def get_products_data():
    """Récupérer les données des produits depuis la base de données"""
    conn = get_db_connection()
    if not conn:
        return pd.DataFrame()
    
    try:
        # Récupérer les produits avec leurs caractéristiques
        query = """
        SELECT p.product_id, p.product_title, p.product_description, 
               p.product_keywords, p.category_id, p.brand_id, p.product_price,
               c.category_title, b.brand_title
        FROM products p
        JOIN categories c ON p.category_id = c.category_id
        JOIN brands b ON p.brand_id = b.brand_id
        """
        
        df = pd.read_sql(query, conn)
        conn.close()
        return df
    except Exception as e:
        print(f"Erreur lors de la récupération des données: {e}")
        conn.close()
        return pd.DataFrame()

def extract_features(df):
    """Extraire et préparer les caractéristiques des produits"""
    # Créer des caractéristiques numériques et textuelles
    
    # 1. Caractéristiques numériques (prix)
    numeric_features = df[['product_price']].copy()
    
    # 2. Caractéristiques catégorielles (one-hot encoding)
    # Catégories
    category_dummies = pd.get_dummies(df['category_id'], prefix='category')
    # Marques
    brand_dummies = pd.get_dummies(df['brand_id'], prefix='brand')
    
    # 3. Caractéristiques textuelles
    # Combiner le texte pour l'analyse TF-IDF plus tard
    df['text_features'] = df['product_title'] + ' ' + df['product_description'] + ' ' + \
                         df['product_keywords'] + ' ' + df['category_title'] + ' ' + df['brand_title']
    
    # Convertir en minuscules
    df['text_features'] = df['text_features'].str.lower()
    
    # Combiner toutes les caractéristiques numériques et catégorielles
    features_df = pd.concat([numeric_features, category_dummies, brand_dummies], axis=1)
    
    return df, features_df

def normalize_features(features_df):
    """Normaliser les caractéristiques avec MinMaxScaler"""
    # Initialiser le scaler MinMax
    scaler = MinMaxScaler()
    
    # Appliquer la normalisation MinMax
    normalized_features = scaler.fit_transform(features_df)
    
    # Convertir en DataFrame pour faciliter la manipulation
    normalized_df = pd.DataFrame(normalized_features, 
                                index=features_df.index, 
                                columns=features_df.columns)
    
    return normalized_df

def calculate_similarity(df, normalized_df):
    """Calculer la similarité entre les produits"""
    # Calculer la similarité cosinus sur les caractéristiques normalisées
    cosine_sim = cosine_similarity(normalized_df)
    
    # Créer un DataFrame pour faciliter l'accès
    similarity_df = pd.DataFrame(cosine_sim, 
                               index=df['product_id'], 
                               columns=df['product_id'])
    
    return similarity_df

def get_recommendations(product_id, similarity_df, df, n_recommendations=5):
    """Obtenir des recommandations pour un produit donné"""
    # Vérifier si le produit existe
    if product_id not in similarity_df.index:
        return []
    
    # Obtenir les scores de similarité pour ce produit
    sim_scores = similarity_df[product_id]
    
    # Trier les produits par score de similarité (exclure le produit lui-même)
    sim_scores = sim_scores.sort_values(ascending=False)[1:n_recommendations+1]
    
    # Obtenir les IDs des produits recommandés
    recommended_ids = sim_scores.index.tolist()
    
    return recommended_ids

def generate_all_recommendations(n_recommendations=5):
    """Générer des recommandations pour tous les produits"""
    # Récupérer les données
    df = get_products_data()
    if df.empty:
        return {}
    
    # Extraire les caractéristiques
    df, features_df = extract_features(df)
    
    # Normaliser les caractéristiques avec MinMax
    normalized_df = normalize_features(features_df)
    
    similarity_df = calculate_similarity(df, normalized_df)
    
    all_recommendations = {}
    for product_id in df['product_id']:
        recommendations = get_recommendations(product_id, similarity_df, df, n_recommendations)
        all_recommendations[str(product_id)] = recommendations
    
    return all_recommendations

def update_recommendations_in_db(recommendations):
    """Mettre à jour les recommandations dans la base de données"""
    conn = get_db_connection()
    if not conn:
        return False
    
    cursor = conn.cursor()
    
    try:

        cursor.execute("""
        CREATE TABLE IF NOT EXISTS product_recommendations (
            product_id INT PRIMARY KEY,
            recommended_products TEXT,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )
        """)
   
        for product_id, recommended_products in recommendations.items():
            recommended_json = json.dumps(recommended_products)

            cursor.execute("""
            INSERT INTO product_recommendations (product_id, recommended_products)
            VALUES (%s, %s)
            ON DUPLICATE KEY UPDATE recommended_products = %s
            """, (product_id, recommended_json, recommended_json))
        
        conn.commit()
        print("Recommandations mises à jour dans la base de données")
        return True
    
    except Exception as e:
        print(f"Erreur lors de la mise à jour des recommandations: {e}")
        conn.rollback()
        return False
    
    finally:
        cursor.close()
        conn.close()

def main():
    """Fonction principale"""
    print("Génération des recommandations avec l'algorithme MinMax...")
    recommendations = generate_all_recommendations()
    
    if recommendations:
        update_recommendations_in_db(recommendations)
        
        print(f"Recommandations générées pour {len(recommendations)} produits")
    else:
        print("Aucune recommandation n'a pu être générée")

if __name__ == "__main__":
    main()