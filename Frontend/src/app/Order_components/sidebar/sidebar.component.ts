import {AfterViewInit, Component} from '@angular/core';

@Component({
  selector: 'app-sidebar',
  templateUrl: './sidebar.component.html',
  styleUrls: ['./sidebar.component.css']
})
export class SidebarComponent implements AfterViewInit {
  ngAfterViewInit(): void {
    const hamBurger = document.querySelector(".toggle-btn");
    const sidebar = document.querySelector("#sidebar");

    hamBurger?.addEventListener("click", function () {
      sidebar?.classList.toggle("expand");


    });


  }

}
