import { Routes } from '@angular/router';
import {LoginComponent} from "./login/login.component";
import {SignupComponent} from "./signup/signup.component";
import {DashboardComponent} from "./dashboard/dashboard.component";
import {MenuPageComponent} from "./menu-page/menu-page.component";

import { MonthlySalesComponent } from './ReportsComponents/monthly-sales/monthly-sales.component';
import { YearlySalesComponent } from './ReportsComponents/yearly-sales/yearly-sales.component';
import { MenuItemOrdersComponent } from './ReportsComponents/menu-item-orders/menu-item-orders.component';
import { FeedbackTrackingComponent } from './ReportsComponents/feedback-tracking/feedback-tracking.component';


export const routes: Routes = [

  { path: 'login', component: LoginComponent },
  { path: 'signup', component: SignupComponent },
  { path: 'dashboard', component: DashboardComponent },
  { path: 'menu', component: MenuPageComponent },
  { path: 'dashboard', component: DashboardComponent  },
  { path: 'feedback-tracking', component: FeedbackTrackingComponent },
  { path: 'menu-item-orders', component: MenuItemOrdersComponent},
  { path: 'monthly-sales', component: MonthlySalesComponent},
  { path: 'yearly-sales', component: YearlySalesComponent},

];
