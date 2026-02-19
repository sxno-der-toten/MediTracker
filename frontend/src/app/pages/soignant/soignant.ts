import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Router } from '@angular/router'; // 1. Ajout de Router

@Component({
  selector: 'app-soignant',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './soignant.html',
  styleUrl: './soignant.css'
})
export class Soignant {
  
  // 2. Injection du Router
  constructor(private router: Router) {}

  submitForm(event: Event) {
    event.preventDefault();
    // 3. Redirection vers l'accueil avec le paramètre 'soignantSuccess'
    this.router.navigate(['/'], { queryParams: { soignantSuccess: 'true' } });
  }
}