(define Revl
  (lambda (x)
    (cond
      ((null? x) '()) 
      (else (cons (Revl (cdr x)) (cons (car x) '()) ) )
      )))