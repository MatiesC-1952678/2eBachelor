(define Revl
  (lambda (x)
    (cond
      ((null? x) '()) 
      ((cons (Revl (cdr x)) (cons (car x) '()) ) )
      )))