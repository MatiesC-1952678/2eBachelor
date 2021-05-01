#ifndef CG1_4DMATRIX_H
#define CG1_4DMATRIX_H

#include <QObject>
#include <CG1_4DVector.h>

class CG1_4DMatrix
{
public:
    CG1_4DMatrix();
    void LoadIdentity();
    CG1_4DMatrix operator*(CG1_4DMatrix other);
    CG1_4DVector operator*(CG1_4DVector v);
    std::vector<double> multiplicate(std::vector<double> other);
    CG1_4DMatrix& operator=(const CG1_4DMatrix &v);
    void Translate(float x, float y, float z);
    void RotateX(float angle);
    void RotateY(float angle);
    void RotateZ(float angle);
    void Scale(float x, float y, float z);
    void setMatrix(std::vector<double> matrix);
    std::vector<double> getMatrix();
    void SetPerspectiveProjection(float d);
    void Transpose();
private:
    std::vector<double> m_Values;					// STL-vector van punten (CG1_2DVectoren)
    //std::vector<CG1_4DMatrix>::iterator PointIterator;	// iterator
};

#endif // CG1_4DMATRIX_H
