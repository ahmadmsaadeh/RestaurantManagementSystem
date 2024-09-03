import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ChifsComponent } from './chefs.component';

describe('ChifsComponent', () => {
  let component: ChifsComponent;
  let fixture: ComponentFixture<ChifsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ChifsComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ChifsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
