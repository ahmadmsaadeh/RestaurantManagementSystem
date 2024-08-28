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

const routes: Routes = [

  {path:'adminDashboard',component:SidebarComponent},
  {path:'orders',component:OrderListComponent},
  {path:'order-detail/:id',component:OrderDetailsComponent},
  { path: 'login', component: LoginComponent },
  { path: 'signup', component: SignupComponent },
  { path: 'dashboard', component: DashboardComponent },

  { path: 'side-with-content', component: SideWithContentComponent },
  {
    path: '', component: SideWithContentComponent, children: [
      { path: 'orders', component: OrderListComponent },
      { path: 'order-detail/:id', component: OrderDetailsComponent },
      { path: 'menu', component: MenuPageComponent },
      { path: '', redirectTo: 'orders', pathMatch: 'full' } // Default route
    ]
  }


];

@NgModule({
  imports: [RouterModule.forRoot(routes),     CommonModule,
  ],
  exports: [RouterModule]
})
export class AppRoutingModule {

}
