import {AfterViewInit, Component} from '@angular/core';

@Component({
  selector: 'app-sidebar',
  templateUrl: './sidebar.component.html',
  styleUrls: ['./sidebar.component.css']
})
export class SidebarComponent implements AfterViewInit {
  ngAfterViewInit(): void {
    const hamBurger = document.querySelector(".toggle-btn") as HTMLElement;
    hamBurger?.addEventListener("click", () => {
      const sidebar = document.querySelector("#sidebar") as HTMLElement;
      sidebar?.classList.toggle("expand");
    });
  }
}
