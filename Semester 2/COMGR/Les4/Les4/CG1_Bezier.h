#ifndef __CG1_BEZIER_H__
#define __CG1_BEZIER_H__

#include <vector>
#include "CG1_ParamCubCurve.h"
#include "CG1_4DVector.h"

enum Iteration_Method
{		
    BRUTEFORCE,		//Brute force iteration
    FD,				//Forward difference iteration
    CASTELJAU		//de Casteljau iteration
};

class CG1_Bezier : public CG1_ParamCubCurve  
{
public:
	CG1_Bezier();
	virtual ~CG1_Bezier();

	void setIterationMethod(enum Iteration_Method m);
	void iterate( int nrofsteps );
	
	void BruteForce (int nrofsteps);
	void Casteljau  (int nrofsteps);
	void ForwardDiff(int nrofsteps);

private:
	bool createGeoMatrix();
	
private:
	enum Iteration_Method m_IterationMethod;	// Iteration method (default: brute force)
};
#endif // __CG1_BEZIER_H__
