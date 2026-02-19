import { Component, OnInit, ChangeDetectorRef } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Router, ActivatedRoute } from '@angular/router';
// 1. IMPORT TRÈS IMPORTANT : FormsModule pour utiliser [(ngModel)]
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [CommonModule, RouterModule, FormsModule], // Ajouté ici aussi
  templateUrl: './home.html',
  styleUrl: './home.css'
})
export class Home implements OnInit {
  showSuccessToast = false;
  toastMessage = '';
  isMobile = false;

  // Tes données de base (intactes)
  doctors = [
    { name: 'Dr. Sophie Martin', specialty: 'Médecin généraliste', location: 'Paris (75)', description: 'Médecin généraliste avec plus de 15 ans d\'expérience...', price: '25€', imageUrl: 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&q=80&w=400&h=300' },
    { name: 'Dr. Thomas Dubois', specialty: 'Cardiologue', location: 'Paris (75)', description: 'Cardiologue expérimenté...', price: '80€', imageUrl: 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&q=80&w=400&h=300' },
    { name: 'Dr. Marie Leclerc', specialty: 'Dermatologue', location: 'Paris (75)', description: 'Dermatologue spécialisée...', price: '70€', imageUrl: 'https://images.unsplash.com/photo-1758691463626-0ab959babe00?q=80&w=1632&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D' },
    { name: 'Dr. Marie Leclerc', specialty: 'Dermatologue', location: 'Paris (75)', description: 'Dermatologue spécialisée...', price: '70€', imageUrl: 'https://images.unsplash.com/photo-1758691463626-0ab959babe00?q=80&w=1632&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D' },
    { name: 'Dr. Thomas Dubois', specialty: 'Cardiologue', location: 'Paris (75)', description: 'Cardiologue expérimenté...', price: '80€', imageUrl: 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&q=80&w=400&h=300' },
    { name: 'Dr. Sophie Martin', specialty: 'Médecin généraliste', location: 'Paris (75)', description: 'Médecin généraliste...', price: '25€', imageUrl: 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&q=80&w=400&h=300' }
  ];

  // --- NOUVEAU : VARIABLES POUR LE FILTRE ---
  filteredDoctors = [...this.doctors]; // C'est ce tableau qu'on va afficher
  searchTerm: string = '';
  selectedSpecialty: string = '';
  specialties: string[] = ['Cardiologue', 'Médecin généraliste', 'Dermatologue'];

  constructor(
    private router: Router,
    private route: ActivatedRoute,
    private cdr: ChangeDetectorRef
  ) { }

  ngOnInit() {
    this.route.queryParams.subscribe(params => {

      if (params['bookingSuccess'] || params['soignantSuccess']) {
        // On définit le bon message
        this.toastMessage = params['bookingSuccess']
          ? 'Rendez-vous confirmé avec succès !'
          : "Votre demande d'inscription a bien été envoyée !";

        this.showSuccessToast = true;

        // 🪄 ASTUCE DE PRO : On nettoie l'URL (enlève le ?bookingSuccess=true) 
        // pour que le toast ne revienne pas si on fait F5 !
        this.router.navigate([], { replaceUrl: true });

        // On fait disparaître après 4 secondes (avec cdr pour forcer l'action)
        setTimeout(() => {
          this.showSuccessToast = false;
          this.cdr.detectChanges();
        }, 4000);
      }
    });

    this.isMobile = window.innerWidth <= 768;
  }

  // --- NOUVEAU : LA LOGIQUE DE FILTRAGE ---
  applyFilters() {
    this.filteredDoctors = this.doctors.filter(doctor => {
      // 1. Vérifie la recherche par nom ou spécialité
      const matchesSearch = doctor.name.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
        doctor.specialty.toLowerCase().includes(this.searchTerm.toLowerCase());

      // 2. Vérifie le menu déroulant
      const matchesSpecialty = this.selectedSpecialty ? doctor.specialty === this.selectedSpecialty : true;

      return matchesSearch && matchesSpecialty;
    });
  }

  // Quand on clique dans le menu déroulant
  setSpecialty(specialty: string) {
    this.selectedSpecialty = specialty;
    this.applyFilters();
  }

  goToBooking(doctor: any) {
    this.router.navigate(['/booking'], { state: { doctorData: doctor } });
  }
}