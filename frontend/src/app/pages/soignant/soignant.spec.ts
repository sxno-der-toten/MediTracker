import { ComponentFixture, TestBed } from '@angular/core/testing';

import { Soignant } from './soignant';

describe('Soignant', () => {
  let component: Soignant;
  let fixture: ComponentFixture<Soignant>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [Soignant]
    })
    .compileComponents();

    fixture = TestBed.createComponent(Soignant);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
