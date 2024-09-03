import { NgModule } from '@angular/core';
import {OrderListComponent} from "./Order_components/order-list/order-list.component";
import {OrderDetailsComponent} from "./Order_components/order-details/order-details.component";
import {RouterModule, Routes} from '@angular/router';
import { LoginComponent } from './login/login.component';
import {SignupComponent} from "./signup/signup.component";
import {DashboardComponent} from "./dashboard/dashboard.component";

import { MenuPageComponent } from './menu-page/menu-page.component';
import { MenuEditComponent } from './menu-edit/menu-edit.component';  //

import {SidebarComponent} from "./Order_components/sidebar/sidebar.component";
import {SideWithContentComponent} from "./Order_components/side-with-content/side-with-content.component";

import {ReservationTableComponent} from "./reservation-table/reservation-table.component";
import {UserReservationComponent} from "./user-reservation/user-reservation.component";
import {ReservationUserManagementComponent} from "./reservation-user-managment/reservation-user-management.component";

import { MonthlySalesComponent } from './ReportsComponents/monthly-sales/monthly-sales.component';
import { YearlySalesComponent } from './ReportsComponents/yearly-sales/yearly-sales.component';
import { MenuItemOrdersComponent } from './ReportsComponents/menu-item-orders/menu-item-orders.component';
import { FeedbackTrackingComponent } from './ReportsComponents/feedback-tracking/feedback-tracking.component';
import {RoleslistComponent} from "./roleslist/roleslist.component";

import {AddOrderComponent} from "./Order_components/add-order/add-order.component";
import {TablesManagementComponent} from "./tables-managment/tables-management.component";
import { FeedbackComponent } from './feedback/feedback.component';

import { ReportsComponent } from './ReportsComponents/reports/reports.component';

import {UserReserveComponent} from "./user-reserve/user-reserve.component";
import { ShowFeedbackComponent } from './FeedbackComponents/show-feedback/show-feedback.component';



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
      { path: 'new-order', component: AddOrderComponent },

      { path: 'menu', component: MenuPageComponent },
      { path: 'menu/edit', component: MenuEditComponent }, //

      { path: 'reservation', component: ReservationTableComponent },
      { path: 'add-reservation', component: UserReservationComponent },
      {path: 'view-reservations', component: ReservationUserManagementComponent },
      {path: 'tables-management',component: TablesManagementComponent},
      {path: 'user-reserve',component: UserReserveComponent},

      { path: 'feedback-tracking', component: FeedbackTrackingComponent },
      { path: 'menu-item-orders', component: MenuItemOrdersComponent},
      { path: 'monthly-sales', component: MonthlySalesComponent},
      { path: 'yearly-sales', component: YearlySalesComponent},
      { path: 'roles-list', component: RoleslistComponent},
      { path: 'menu-item-orders', component: MenuItemOrdersComponent },
      { path: 'monthly-sales', component: MonthlySalesComponent },

      { path: 'yearly-sales', component: YearlySalesComponent },
      { path: 'feedback', component: FeedbackComponent },
      { path: 'reports', component: ReportsComponent},
      { path: 'showFeedbacks', component:  ShowFeedbackComponent},
    ]
  },



];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule {

}
