import schedule
import time
from recommendation_minmax import main as update_recommendations

def job():
    print("Mise à jour des recommandations...")
    update_recommendations()
    print("Mise à jour terminée!")

# Exécuter immédiatement une première fois
job()

# Planifier l'exécution quotidienne à 3h du matin
schedule.every().day.at("03:00").do(job)

# Boucle principale
while True:
    schedule.run_pending()
    time.sleep(60)  # Vérifier toutes les minutes