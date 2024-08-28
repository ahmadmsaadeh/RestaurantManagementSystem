import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SideWithContentComponent } from './side-with-content.component';

describe('SideWithContentComponent', () => {
  let component: SideWithContentComponent;
  let fixture: ComponentFixture<SideWithContentComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ SideWithContentComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(SideWithContentComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
