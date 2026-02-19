import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-dashboard',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './dashboard.html',
  styleUrl: './dashboard.css'
})
export class Dashboard {
  // Par défaut, on affiche l'onglet "Rendez-vous"
  currentView: 'appointments' | 'doctors' = 'appointments';

  // Statistiques mockées
  stats = {
    appointments: 20,
    activeDoctors: 10,
    pendingDoctors: 2
  };

  // Liste des médecins mockés (selon ta maquette)
  doctors = [
    { name: 'Dr. Thomas Dubois', specialty: 'Cardiologue', location: 'Paris', imageUrl: 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&q=80&w=150&h=150' },
    { name: 'Dr. Thomas Dubois', specialty: 'Cardiologue', location: 'Paris', imageUrl: 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&q=80&w=150&h=150' },
    { name: 'Dr. Thomas Dubois', specialty: 'Cardiologue', location: 'Paris', imageUrl: 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&q=80&w=150&h=150' }
  ];

  // Fonction pour changer de vue
  switchView(view: 'appointments' | 'doctors') {
    this.currentView = view;
  }

  // Fonction pour le bouton rouge
  suspendDoctor(doctorName: string) {
    alert(`Le compte du ${doctorName} a été suspendu (Simulation).`);
  }
}