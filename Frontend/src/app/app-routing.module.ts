import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import {OrderListComponent} from "./Order_components/order-list/order-list.component";
import {OrderDetailsComponent} from "./Order_components/order-details/order-details.component";

const routes: Routes = [
  {path:'orders',component:OrderListComponent},
  {path:'order-detail/:id',component:OrderDetailsComponent}

];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
