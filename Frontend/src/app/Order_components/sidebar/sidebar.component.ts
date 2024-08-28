import {AfterViewInit, Component} from '@angular/core';
<<<<<<< HEAD
import {RouterLink} from "@angular/router";
=======
>>>>>>> f25b4ce21932ad297743a1729f03fb5c769da2c7

@Component({
  selector: 'app-sidebar',
  templateUrl: './sidebar.component.html',
<<<<<<< HEAD
  standalone: true,
  imports: [
    RouterLink
  ],
=======
>>>>>>> f25b4ce21932ad297743a1729f03fb5c769da2c7
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
