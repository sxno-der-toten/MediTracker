import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
// 1. IMPORTANT : FormsModule pour que les champs soient modifiables
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';

@Component({
  selector: 'app-profile',
  standalone: true,
  // 2. On ajoute FormsModule aux imports
  imports: [CommonModule, FormsModule],
  templateUrl: './profile.html',
  styleUrl: './profile.css'
})
export class Profile {
  // Données mockées de l'utilisateur connecté (conforme à ta maquette)
  user = {
    fullName: 'Administrateur',
    email: 'admin@meditracker.fr',
    role: 'Administrateur',
    // Si une photo existe, on met l'URL ici, sinon on laisse null pour afficher l'initiale
    photoUrl: null 
  };

  constructor(private router: Router) {}

  // Petite fonction utilitaire pour avoir la première lettre du nom en majuscule
  getInitials(): string {
    return this.user.fullName ? this.user.fullName.charAt(0).toUpperCase() : '';
  }

  // Simulation de la sauvegarde
  saveChanges() {
    // Ici, tu appelleras plus tard ton API Symfony avec un PUT
    alert('Modifications enregistrées avec succès ! (Simulation)');
  }

  // Simulation de la déconnexion
  logout() {
    // Ici, tu supprimeras le token du localStorage
    // localStorage.removeItem('token'); 
    this.router.navigate(['/']);
  }
}