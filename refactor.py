import os

files_to_replace = [
    r"c:\xampp\htdocs\sistema_reservas\index.php",
    r"c:\xampp\htdocs\sistema_reservas\views\ReservationView.php",
    r"c:\xampp\htdocs\sistema_reservas\views\ReportView.php",
    r"c:\xampp\htdocs\sistema_reservas\views\AuthView.php",
    r"c:\xampp\htdocs\sistema_reservas\templates\reports.php",
    r"c:\xampp\htdocs\sistema_reservas\templates\login.php",
    r"c:\xampp\htdocs\sistema_reservas\templates\home.php",
]

for filepath in files_to_replace:
    if not os.path.exists(filepath):
        print(f"Not found: {filepath}")
        continue
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    # Replacements
    if "index.php" in filepath:
        content = content.replace("controllers/", "views/")
        content = content.replace("Controller", "View")
        content = content.replace("controller", "view")
    
    if "views\\" in filepath:
        content = content.replace("Controller", "View")
        content = content.replace("controller=", "view=")
        content = content.replace("controller&", "view&")
        content = content.replace("views/", "templates/")

    if "templates\\" in filepath:
        content = content.replace("?controller=", "?view=")

    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)
print("Replacement completed.")
