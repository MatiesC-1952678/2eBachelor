(define Prependl
  (lambda (x y)
    (cond
      ((null? x) y)
      (else (cons (car x) (Prependl (cdr x) y)))
      )))

(define Revl
  (lambda (x)
    (cond
      ((null? x) '()) 
      ((Prependl (Revl (cdr x)) (cons (car x) '()) ) )
      )))

(revl '(a (b) c))