import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Router } from '@angular/router';

@Component({
  selector: 'app-booking',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './booking.html',
  styleUrl: './booking.css'
})
export class Booking implements OnInit {
  step: number = 1;
  doctor: any;
  
  selectedDate: any = null;
  selectedTime: string | null = null;
  
  availableDates: any[] = [];
  currentOffset = 0; // Pour savoir de combien de jours on a avancé

  // Créneaux avec la notion de disponibilité pour faire réaliste !
  morningSlots = [
    { time: '9:00', available: true },
    { time: '9:30', available: false }, // Indisponible !
    { time: '10:00', available: true },
    { time: '10:30', available: true },
    { time: '11:00', available: false },
    { time: '11:30', available: true }
  ];
  afternoonSlots = [
    { time: '14:00', available: true },
    { time: '14:30', available: true },
    { time: '15:00', available: false },
    { time: '15:30', available: true },
    { time: '16:00', available: true },
    { time: '16:30', available: false },
    { time: '17:00', available: true }
  ];

  constructor(private router: Router) {
    // On récupère les infos envoyées par la page d'accueil
    const navigation = this.router.getCurrentNavigation();
    if (navigation?.extras.state?.['doctorData']) {
      this.doctor = navigation.extras.state['doctorData'];
    } else {
      // Sécurité : si on tape /booking directement, on met des infos par défaut
      this.doctor = {
        name: 'Dr. Jean Moreau',
        specialty: 'Pédiatre',
        price: '50€',
        imageUrl: 'https://images.unsplash.com/photo-1612349317150-e410f624c427?auto=format&fit=crop&q=80&w=400&h=400'
      };
    }
  }

  ngOnInit() {
    this.generateDates();
  }

  // --- LOGIQUE CALENDRIER ---
  generateDates() {
    this.availableDates = [];
    const today = new Date();
    today.setDate(today.getDate() + this.currentOffset); // On décale selon les clics
    
    const jours = ['dim.', 'lun.', 'mar.', 'mer.', 'jeu.', 'ven.', 'sam.'];
    
    for (let i = 0; i < 7; i++) {
      const date = new Date(today);
      date.setDate(today.getDate() + i);
      this.availableDates.push({
        fullDate: date,
        dayName: jours[date.getDay()],
        dayNumber: date.getDate(),
        monthName: date.toLocaleDateString('fr-FR', { month: 'long', year: 'numeric' })
      });
    }
  }

  nextDays() {
    this.currentOffset += 7;
    this.generateDates();
  }

  prevDays() {
    if (this.currentOffset >= 7) { // On empêche de remonter dans le passé
      this.currentOffset -= 7;
      this.generateDates();
    }
  }

  // --- LOGIQUE STEPS ---
  selectDate(date: any) {
    this.selectedDate = date;
    this.step = 2;
  }

  selectTime(time: string) {
    this.selectedTime = time;
    this.step = 3;
  }

  goBackToDate() { this.step = 1; this.selectedTime = null; }
  goBackToTime() { this.step = 2; }

  // --- SOUMISSION FINALE ---
  confirmBooking(event: Event) {
    event.preventDefault(); // Empêche la page de se recharger
    // Ici plus tard : Appel à l'API Symfony de ton pote !
    
    // On redirige vers l'accueil avec un paramètre de succès
    this.router.navigate(['/'], { queryParams: { bookingSuccess: 'true' } });
  }
}