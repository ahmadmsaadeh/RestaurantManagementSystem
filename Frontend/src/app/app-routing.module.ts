import { NgModule } from '@angular/core';
import {OrderListComponent} from "./Order_components/order-list/order-list.component";
import {OrderDetailsComponent} from "./Order_components/order-details/order-details.component";
import {Router, RouterModule, Routes} from '@angular/router';
import { LoginComponent } from './login/login.component';
import {SignupComponent} from "./signup/signup.component";
import {DashboardComponent} from "./dashboard/dashboard.component";
import { MenuPageComponent } from './menu-page/menu-page.component';
import {SidebarComponent} from "./Order_components/sidebar/sidebar.component";
import {SideWithContentComponent} from "./Order_components/side-with-content/side-with-content.component";
import {CommonModule} from "@angular/common";
import {ReservationTableComponent} from "./reservation-table/reservation-table.component";
import {UserReservationComponent} from "./user-reservation/user-reservation.component";

import { MonthlySalesComponent } from './monthly-sales/monthly-sales.component';
import { YearlySalesComponent } from './yearly-sales/yearly-sales.component';
import { MenuItemOrdersComponent } from './menu-item-orders/menu-item-orders.component';
import { FeedbackTrackingComponent } from './feedback-tracking/feedback-tracking.component';
import {RoleslistComponent} from "./roleslist/roleslist.component";


const routes: Routes = [

  {path:'adminDashboard',component:SidebarComponent},
  { path: 'login', component: LoginComponent },
  { path: 'signup', component: SignupComponent },
  { path: 'dashboard', component: DashboardComponent },

  { path: 'side-with-content', component: SideWithContentComponent },
  {
    path: 'side-with-content', component: SideWithContentComponent, children: [
      { path: 'orders', component: OrderListComponent },
      { path: 'order-detail/:id', component: OrderDetailsComponent },
      { path: 'menu', component: MenuPageComponent },
      { path: 'reservation', component: ReservationTableComponent },
      { path: 'add-reservation', component: UserReservationComponent },
      { path: 'feedback-tracking', component: FeedbackTrackingComponent },
      { path: 'menu-item-orders', component: MenuItemOrdersComponent},
      { path: 'monthly-sales', component: MonthlySalesComponent},
      { path: 'yearly-sales', component: YearlySalesComponent},
      { path: 'roles-list', component: RoleslistComponent},
    ]
  }


];

@NgModule({
  imports: [RouterModule.forRoot(routes),
    CommonModule,
  ],
  exports: [RouterModule]
})
export class AppRoutingModule {

}
