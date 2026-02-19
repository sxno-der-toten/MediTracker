import { Routes } from '@angular/router';
import { Home } from './pages/home/home';
import { Login } from './pages/login/login';
import { Register } from './pages/register/register';
import { Booking } from './pages/booking/booking';
import { Dashboard } from './pages/dashboard/dashboard';
import { Profile } from './pages/profile/profile';
import { Soignant } from './pages/soignant/soignant';

export const routes: Routes = [
  { path: '', component: Home },
  { path: 'login', component: Login },
  { path: 'register', component: Register },
  { path: 'booking', component: Booking },
  { path: 'dashboard', component: Dashboard },
  { path: 'profile', component: Profile },
  { path: 'soignant', component: Soignant },
  { path: '**', redirectTo: '' }
];